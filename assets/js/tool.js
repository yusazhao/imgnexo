(function () {
	var editor = document.getElementById('editor');
	if (!editor) return;

	var mode = editor.getAttribute('data-mode');
	var presetName = editor.getAttribute('data-preset') || (mode === 'unblur' ? 'sharpen' : 'soft');
	var presets = {
		soft: { effect: 'gaussian', gaussian: 0, pixel: 1, scope: 'whole', brush: 48 },
		background: { effect: 'gaussian', gaussian: 18, pixel: 12, scope: 'brush', brush: 72 },
		face: { effect: 'pixel', gaussian: 4, pixel: 16, scope: 'brush', brush: 46 },
		text: { effect: 'gaussian', gaussian: 14, pixel: 12, scope: 'brush', brush: 26 },
		online: { effect: 'gaussian', gaussian: 10, pixel: 8, scope: 'whole', brush: 48 },
		effect: { effect: 'gaussian', gaussian: 8, pixel: 10, scope: 'whole', brush: 48 },
		sharpen: { sharpen: 110, radius: 1.4, contrast: 8 },
		photos: { sharpen: 130, radius: 1.6, contrast: 10 },
		iphone: { sharpen: 120, radius: 1.3, contrast: 8 },
		motion: { sharpen: 180, radius: 2.4, contrast: 6 }
	};

	var fileInput = document.getElementById('file');
	var dropzone = document.getElementById('dropzone');
	var editorStage = editor.querySelector('.editor-stage');
	var stage = document.getElementById('stage');
	var stageViewport = document.getElementById('stage-viewport');
	var stageSizer = editor.querySelector('.stage-sizer');
	var stageCanvas = document.getElementById('stage-canvas');
	var view = document.getElementById('view');
	var ink = document.getElementById('ink');
	var status = document.getElementById('status');
	var intensity = document.getElementById('intensity');
	var brush = document.getElementById('brush');
	var brushGroup = document.getElementById('brush-group');
	var effectNames = ['gaussian', 'pixel', 'noise', 'motion', 'radial', 'color'];
	var effectButtons = {};
	effectNames.forEach(function (name) {
		effectButtons[name] = document.getElementById('effect-' + name);
	});
	var scopeWholeBtn = document.getElementById('scope-whole');
	var scopeBrushBtn = document.getElementById('scope-brush');
	var scopeMarqueeBtn = document.getElementById('scope-marquee');
	var scopeLassoBtn = document.getElementById('scope-lasso');
	var sharpen = document.getElementById('sharpen');
	var radius = document.getElementById('radius');
	var contrast = document.getElementById('contrast');
	var downloadBtn = document.getElementById('download');
	var originalBtn = document.getElementById('original');
	var replaceBtn = document.getElementById('replace');
	var sampleBtn = document.getElementById('sample');
	var undoBtn = document.getElementById('undo');
	var redoBtn = document.getElementById('redo');
	var resetBtn = document.getElementById('reset-image');
	var zoomBar = document.getElementById('zoom-bar');
	var zoomInput = document.getElementById('zoom');
	var zoomOutBtn = document.getElementById('zoom-out-btn');
	var zoomInBtn = document.getElementById('zoom-in-btn');
	var zoomFitBtn = document.getElementById('zoom-fit');
	var batchEnabled = editor.getAttribute('data-batch') === '1';
	var jobSingleBtn = document.getElementById('job-single');
	var jobBatchBtn = document.getElementById('job-batch');
	var batchBox = document.getElementById('batch');
	var historyBar = document.getElementById('history-bar');
	var editorNote = document.getElementById('editor-note');
	var dropTitle = dropzone.querySelector('.drop-title');
	var selectBtn = dropzone.querySelector('.select-btn');
	var jobName = 'single';
	var batchItems = [];
	var batchAddBtn = document.getElementById('batch-add');
	var batchClearBtn = document.getElementById('batch-clear');
	var batchAppend = false;
	var loadToken = 0;
	var BATCH_LIMIT = 12;

	var source = document.createElement('canvas');
	var effect = document.createElement('canvas');
	var result = document.createElement('canvas');
	var mask = document.createElement('canvas');
	var shape = document.createElement('canvas');
	var temp = document.createElement('canvas');
	var small = document.createElement('canvas');
	var ready = false;
	var showingOriginal = false;
	var painting = false;
	var panning = false;
	var spaceDown = false;
	var panStart = null;
	var frame = 0;
	var effectKey = '';
	var zoom = 1;
	var strokes = [];
	var strokeDraft = null;
	var history = [];
	var historyAt = -1;
	var applyingHistory = false;
	var effectName = 'gaussian';
	var scopeName = 'whole';
	var strengths = { gaussian: 0, pixel: 1, noise: 0, motion: 0, radial: 0, color: 0 };

	Array.prototype.forEach.call(editor.querySelectorAll('[data-for]'), function (el) {
		el.hidden = el.getAttribute('data-for') !== mode;
	});

	function applyPreset() {
		var preset = presets[presetName] || presets.soft;
		if (mode === 'blur') {
			effectName = strengths[preset.effect] != null ? preset.effect : 'gaussian';
			strengths.gaussian = preset.gaussian;
			strengths.pixel = preset.pixel;
			scopeName = preset.scope === 'brush' ? 'brush' : 'whole';
			brush.value = preset.brush;
		} else {
			sharpen.value = preset.sharpen;
			radius.value = preset.radius;
			contrast.value = preset.contrast;
		}
		syncLabels();
	}

	function effectIdle() {
		var amount = Number(strengths[effectName] || 0);
		return effectName === 'pixel' ? amount <= 1 : amount <= 0;
	}

	function syncLabels() {
		var strength = Number(strengths[effectName] || 0);
		intensity.min = effectName === 'pixel' ? '1' : '0';
		intensity.max = '40';
		intensity.value = String(strength);
		document.getElementById('intensity-out').textContent = (effectName === 'pixel' && strength <= 1) ? 'off' : strength + ' px';
		document.getElementById('brush-out').textContent = brush.value + ' px';
		document.getElementById('zoom-out').textContent = Math.round(zoom * 100) + '%';
		document.getElementById('sharpen-out').textContent = (Number(sharpen.value) / 100).toFixed(2);
		document.getElementById('radius-out').textContent = Number(radius.value).toFixed(1) + ' px';
		document.getElementById('contrast-out').textContent = contrast.value;
		syncScope();
	}

	function setChoice(button, on) {
		if (!button) return;
		button.classList.toggle('is-on', on);
		button.setAttribute('aria-pressed', on ? 'true' : 'false');
	}

	function regionActive() {
		return mode === 'blur' && jobName !== 'batch' && scopeName !== 'whole';
	}

	function syncScope() {
		if (jobName === 'batch') scopeName = 'whole';
		var brushing = regionActive() && scopeName === 'brush';
		var regional = regionActive();
		effectNames.forEach(function (name) {
			if (effectButtons[name]) setChoice(effectButtons[name], effectName === name);
		});
		setChoice(scopeWholeBtn, scopeName === 'whole');
		setChoice(scopeBrushBtn, scopeName === 'brush');
		setChoice(scopeMarqueeBtn, scopeName === 'marquee');
		setChoice(scopeLassoBtn, scopeName === 'lasso');
		[scopeBrushBtn, scopeMarqueeBtn, scopeLassoBtn].forEach(function (button) {
			if (button) button.disabled = jobName === 'batch';
		});
		brushGroup.hidden = !brushing;
		stage.classList.toggle('is-region', regional);
		ink.style.visibility = regional ? 'visible' : 'hidden';
	}

	function syncJob() {
		if (!batchEnabled) return;
		var batch = jobName === 'batch';
		setChoice(jobSingleBtn, !batch);
		setChoice(jobBatchBtn, batch);
		fileInput.multiple = batch;
		historyBar.hidden = batch;
		if (sampleBtn) sampleBtn.hidden = batch;
		originalBtn.hidden = batch;
		if (editorNote && editorNote.getAttribute('data-batch')) {
			editorNote.textContent = batch ? editorNote.getAttribute('data-batch') : editorNote.getAttribute('data-single');
		}
		if (dropTitle) dropTitle.textContent = batch ? 'Click or drag images here' : 'Click or drag an image here';
		if (selectBtn) selectBtn.textContent = batch ? 'Select images' : 'Select image';
		replaceBtn.textContent = 'Replace image';
		downloadBtn.textContent = batch ? 'Download all' : 'Download';
		if (batchAddBtn) batchAddBtn.hidden = !(batch && batchItems.length);
		if (batchClearBtn) batchClearBtn.hidden = !(batch && batchItems.length);
		if (batch) {
			replaceBtn.hidden = true;
			stage.hidden = true;
			zoomBar.hidden = true;
			batchBox.hidden = !batchItems.length;
			dropzone.hidden = batchItems.length > 0;
		}
		syncScope();
	}

	function setStatus(message) {
		status.textContent = message;
	}

	function sizeTo(canvas, w, h) {
		canvas.width = w;
		canvas.height = h;
	}

	function setSourceFromImage(img) {
		var maxEdge = 1600;
		var scale = Math.min(1, maxEdge / Math.max(img.width, img.height));
		var w = Math.max(1, Math.round(img.width * scale));
		var h = Math.max(1, Math.round(img.height * scale));
		[source, effect, result, mask, shape, temp, view, ink].forEach(function (canvas) {
			sizeTo(canvas, w, h);
		});
		effectKey = '';
		source.getContext('2d').drawImage(img, 0, 0, w, h);
		ready = true;
		dropzone.hidden = true;
		stage.hidden = false;
		replaceBtn.hidden = false;
		downloadBtn.disabled = false;
		originalBtn.disabled = false;
		zoom = 1;
		zoomInput.value = '100';
		zoomBar.hidden = mode !== 'blur';
		strokes = [];
		strokeDraft = null;
		history = [];
		historyAt = -1;
		clearMask();
		pushHistory();
		layoutStage();
		requestRender();
		syncJob();
	}

	function maxViewportHeight() {
		return Math.round(Math.min(window.innerHeight * 0.7, 720));
	}

	function updateZoomControls() {
		var percent = Math.round(zoom * 100);
		document.getElementById('zoom-out').textContent = percent + '%';
		zoomOutBtn.disabled = percent <= 100;
		zoomInBtn.disabled = percent >= 400;
		zoomFitBtn.disabled = percent <= 100;
	}

	function paintCanvasBox(canvas, width, height) {
		canvas.style.width = width + 'px';
		canvas.style.height = height + 'px';
		canvas.style.maxWidth = 'none';
		canvas.style.maxHeight = 'none';
	}

	function layoutStage(focus) {
		if (!ready) return;
		var maxH = maxViewportHeight();
		var outerW = editorStage.clientWidth;
		if (outerW < 2 || maxH < 2 || !view.width || !view.height) return;
		var fit = Math.min(outerW / view.width, maxH / view.height);
		var frameW = Math.max(1, Math.min(outerW, Math.floor(view.width * fit)));
		var frameH = Math.max(1, Math.min(maxH, Math.floor(view.height * fit)));
		var dispW = Math.max(1, Math.floor(frameW * zoom));
		var dispH = Math.max(1, Math.floor(frameH * zoom));
		var hugged = zoom <= 1.001;
		var canvasRect = view.getBoundingClientRect();
		var viewRect = stageViewport.getBoundingClientRect();
		var hasSize = canvasRect.width > 1 && canvasRect.height > 1;
		var ratioX = 0.5;
		var ratioY = 0.5;
		if (hasSize) {
			var anchorX = focus ? focus.x : (viewRect.left + stageViewport.clientWidth / 2);
			var anchorY = focus ? focus.y : (viewRect.top + stageViewport.clientHeight / 2);
			ratioX = (anchorX - canvasRect.left) / canvasRect.width;
			ratioY = (anchorY - canvasRect.top) / canvasRect.height;
		}
		stage.style.width = frameW + 'px';
		stage.style.maxWidth = '100%';
		stageViewport.style.width = '100%';
		stageViewport.style.overflowX = hugged ? 'hidden' : 'auto';
		stageViewport.style.overflowY = 'hidden';
		stageViewport.style.height = dispH + 'px';
		stageSizer.style.width = dispW + 'px';
		stageSizer.style.height = dispH + 'px';
		stageCanvas.style.width = dispW + 'px';
		stageCanvas.style.height = dispH + 'px';
		paintCanvasBox(view, dispW, dispH);
		paintCanvasBox(ink, dispW, dispH);
		if (!hugged && stageViewport.scrollWidth > stageViewport.clientWidth) {
			var bar = stageViewport.offsetHeight - stageViewport.clientHeight;
			if (bar > 0) stageViewport.style.height = (dispH + bar) + 'px';
		}
		stage.classList.toggle('is-zoomed', !hugged);
		if (hugged) {
			stageViewport.scrollLeft = 0;
			stageViewport.scrollTop = 0;
		} else if (hasSize) {
			var nextRect = view.getBoundingClientRect();
			var nextView = stageViewport.getBoundingClientRect();
			var desiredX = focus ? focus.x : (nextView.left + stageViewport.clientWidth / 2);
			var desiredY = focus ? focus.y : (nextView.top + stageViewport.clientHeight / 2);
			stageViewport.scrollLeft += (nextRect.left + ratioX * nextRect.width) - desiredX;
			stageViewport.scrollTop += (nextRect.top + ratioY * nextRect.height) - desiredY;
		}
		updateZoomControls();
	}

	function setZoom(percent, focus) {
		if (mode !== 'blur') return;
		percent = Math.round(percent);
		if (percent < 100) percent = 100;
		if (percent > 400) percent = 400;
		zoom = percent / 100;
		if (document.activeElement !== zoomInput) zoomInput.value = String(percent);
		layoutStage(focus);
		updateZoomControls();
	}

	function loadFile(file, note) {
		if (!file || file.type.indexOf('image/') !== 0) {
			setStatus('Choose a JPG, PNG, or WEBP image.');
			return;
		}
		var url = URL.createObjectURL(file);
		var img = new Image();
		img.onload = function () {
			URL.revokeObjectURL(url);
			setSourceFromImage(img);
			setStatus(note || 'Preview ready. Your image stays in this browser.');
		};
		img.onerror = function () {
			URL.revokeObjectURL(url);
			setStatus('This browser could not read that file. Try JPG or PNG.');
		};
		img.src = url;
	}

	function drawSampleScene(ctx, w, h) {
		var sky = ctx.createLinearGradient(0, 0, 0, h);
		sky.addColorStop(0, '#8ec6d8');
		sky.addColorStop(1, '#efe6d4');
		ctx.fillStyle = sky;
		ctx.fillRect(0, 0, w, h);
		ctx.fillStyle = '#d7c4a4';
		ctx.fillRect(0, h * 0.62, w, h * 0.38);
		ctx.fillStyle = '#f2d7bd';
		ctx.beginPath();
		ctx.arc(w * 0.48, h * 0.42, Math.min(w, h) * 0.12, 0, Math.PI * 2);
		ctx.fill();
		ctx.fillStyle = '#3d6d8a';
		ctx.fillRect(w * 0.38, h * 0.54, w * 0.2, h * 0.28);
		ctx.fillStyle = '#1c1915';
		ctx.font = 'bold ' + Math.round(h * 0.045) + 'px Georgia, serif';
		ctx.fillText('ACCT 4491', w * 0.08, h * 0.18);
	}

	function loadSample() {
		var w = 960;
		var h = 640;
		var scene = document.createElement('canvas');
		sizeTo(scene, w, h);
		drawSampleScene(scene.getContext('2d'), w, h);
		if (mode === 'unblur') {
			var soft = document.createElement('canvas');
			sizeTo(soft, w, h);
			var sctx = soft.getContext('2d');
			sctx.filter = 'blur(6px)';
			sctx.drawImage(scene, 0, 0);
			sctx.filter = 'none';
			scene = soft;
		}
		setSourceFromImage(scene);
		setStatus(mode === 'unblur'
			? 'Sample loaded. Raise clarity and compare it with the original.'
			: 'Sample loaded. Blur the whole image, or paint over the face and text.');
	}

	function clearMask() {
		mask.getContext('2d').clearRect(0, 0, mask.width, mask.height);
		ink.getContext('2d').clearRect(0, 0, ink.width, ink.height);
	}

	function currentSettings() {
		if (mode === 'blur') {
			return {
				effect: effectName,
				gaussian: strengths.gaussian,
				pixel: strengths.pixel,
				noise: strengths.noise,
				motion: strengths.motion,
				radial: strengths.radial,
				color: strengths.color,
				scope: scopeName,
				brush: brush.value
			};
		}
		return {
			sharpen: sharpen.value,
			radius: radius.value,
			contrast: contrast.value
		};
	}

	function sameStrokeList(a, b) {
		if (a.length !== b.length) return false;
		for (var i = 0; i < a.length; i++) if (a[i] !== b[i]) return false;
		return true;
	}

	function sameSettings(a, b) {
		var key;
		for (key in a) {
			if (String(a[key]) !== String(b[key])) return false;
		}
		return true;
	}

	function applySettings(settings) {
		if (mode === 'blur') {
			effectName = strengths[settings.effect] != null ? settings.effect : 'gaussian';
			effectNames.forEach(function (name) {
				if (settings[name] != null) strengths[name] = Number(settings[name]);
			});
			scopeName = settings.scope === 'brush' || settings.scope === 'marquee' || settings.scope === 'lasso' ? settings.scope : 'whole';
			brush.value = settings.brush;
		} else {
			sharpen.value = settings.sharpen;
			radius.value = settings.radius;
			contrast.value = settings.contrast;
		}
		syncLabels();
	}

	function drawStroke(ctx, stroke, color) {
		var pts = stroke.points;
		if (!pts.length) return;
		ctx.lineCap = 'round';
		ctx.lineJoin = 'round';
		ctx.strokeStyle = color;
		ctx.fillStyle = color;
		ctx.lineWidth = stroke.size;
		if (pts.length === 1) {
			ctx.beginPath();
			ctx.arc(pts[0].x, pts[0].y, stroke.size / 2, 0, Math.PI * 2);
			ctx.fill();
			return;
		}
		ctx.beginPath();
		ctx.moveTo(pts[0].x, pts[0].y);
		for (var i = 1; i < pts.length; i++) ctx.lineTo(pts[i].x, pts[i].y);
		ctx.stroke();
	}

	function drawMarquee(ctx, stroke) {
		if (stroke.points.length < 2) return;
		var a = stroke.points[0];
		var b = stroke.points[1];
		ctx.fillStyle = '#fff';
		ctx.fillRect(Math.min(a.x, b.x), Math.min(a.y, b.y), Math.abs(a.x - b.x), Math.abs(a.y - b.y));
	}

	function drawLasso(ctx, stroke) {
		var pts = stroke.points;
		if (pts.length < 3) return;
		ctx.fillStyle = '#fff';
		ctx.beginPath();
		ctx.moveTo(pts[0].x, pts[0].y);
		for (var i = 1; i < pts.length; i++) ctx.lineTo(pts[i].x, pts[i].y);
		ctx.closePath();
		ctx.fill();
	}

	function traceSelection(ctx, stroke) {
		var kind = stroke.kind || 'brush';
		ctx.beginPath();
		if (kind === 'marquee' && stroke.points.length >= 2) {
			var a = stroke.points[0];
			var b = stroke.points[1];
			ctx.rect(Math.min(a.x, b.x), Math.min(a.y, b.y), Math.abs(a.x - b.x), Math.abs(a.y - b.y));
		} else if (kind === 'lasso' && stroke.points.length) {
			ctx.moveTo(stroke.points[0].x, stroke.points[0].y);
			for (var i = 1; i < stroke.points.length; i++) ctx.lineTo(stroke.points[i].x, stroke.points[i].y);
			ctx.closePath();
		} else {
			return;
		}
		var box = ink.getBoundingClientRect();
		var scale = box.width ? ink.width / box.width : 1;
		ctx.lineWidth = Math.max(1, 1.5 * scale);
		ctx.setLineDash([]);
		ctx.strokeStyle = 'white';
		ctx.stroke();
		ctx.strokeStyle = '#2563eb';
		ctx.setLineDash([5 * scale, 4 * scale]);
		ctx.stroke();
		ctx.setLineDash([]);
	}

	function selectionUseful(stroke) {
		if (!stroke || !stroke.points.length) return false;
		var kind = stroke.kind || 'brush';
		if (kind === 'brush') return true;
		if (kind === 'marquee') {
			if (stroke.points.length < 2) return false;
			var a = stroke.points[0];
			var b = stroke.points[1];
			return Math.abs(a.x - b.x) >= 2 && Math.abs(a.y - b.y) >= 2;
		}
		return stroke.points.length >= 3;
	}

	function redrawMask() {
		clearMask();
		var sctx = shape.getContext('2d');
		sctx.clearRect(0, 0, shape.width, shape.height);
		sctx.globalCompositeOperation = 'source-over';
		var list = strokes.slice();
		if (strokeDraft && strokeDraft.points.length) list.push(strokeDraft);
		list.forEach(function (stroke) {
			var kind = stroke.kind || 'brush';
			if (kind === 'marquee') drawMarquee(sctx, stroke);
			else if (kind === 'lasso') drawLasso(sctx, stroke);
			else drawStroke(sctx, stroke, '#fff');
		});
		mask.getContext('2d').drawImage(shape, 0, 0);
		var ictx = ink.getContext('2d');
		list.forEach(function (stroke) { traceSelection(ictx, stroke); });
	}

	function updateHistoryButtons() {
		undoBtn.disabled = !ready || historyAt <= 0;
		redoBtn.disabled = !ready || historyAt >= history.length - 1;
		resetBtn.disabled = !ready;
	}

	function pushHistory() {
		var entry = { settings: currentSettings(), strokes: strokes.slice() };
		if (historyAt >= 0 && sameSettings(history[historyAt].settings, entry.settings) && sameStrokeList(history[historyAt].strokes, entry.strokes)) {
			updateHistoryButtons();
			return;
		}
		history = history.slice(0, historyAt + 1);
		history.push(entry);
		if (history.length > 40) history.shift();
		historyAt = history.length - 1;
		updateHistoryButtons();
	}

	function restoreHistory() {
		var entry = history[historyAt];
		if (!entry) return;
		applyingHistory = true;
		applySettings(entry.settings);
		strokes = entry.strokes.slice();
		redrawMask();
		applyingHistory = false;
		updateHistoryButtons();
		requestRender();
	}

	function undo() {
		if (!ready || historyAt <= 0 || painting) return;
		historyAt--;
		restoreHistory();
	}

	function redo() {
		if (!ready || historyAt >= history.length - 1 || painting) return;
		historyAt++;
		restoreHistory();
	}

	function commitSettings() {
		if (jobName === 'batch' || !ready || applyingHistory) return;
		pushHistory();
	}

	function restoreImage() {
		if (!ready || painting) return;
		applyingHistory = true;
		applyPreset();
		zoom = 1;
		zoomInput.value = '100';
		strokes = [];
		strokeDraft = null;
		redrawMask();
		applyingHistory = false;
		layoutStage();
		pushHistory();
		requestRender();
		setStatus('Image restored. Paint and adjustments are back to the start.');
	}

	function effectCacheKey() {
		if (mode === 'unblur') {
			return ['unblur', sharpen.value, radius.value, contrast.value, source.width, source.height].join('|');
		}
		return ['blur', effectName, strengths.gaussian, strengths.pixel, strengths.noise, strengths.motion, strengths.radial, strengths.color, source.width, source.height].join('|');
	}

	function batchReferenceEdge() {
		var edge = 1;
		batchItems.forEach(function (item) {
			edge = Math.max(edge, item.source.width, item.source.height);
		});
		return edge;
	}

	function clampInt(v, max) {
		return v < 0 ? 0 : (v > max ? max : v);
	}

	function hashUnit(x, y) {
		var n = (x * 374761393 + y * 668265263) | 0;
		n = Math.imul(n ^ (n >>> 13), 1274126177);
		return ((n ^ (n >>> 16)) >>> 0) / 4294967296;
	}

	function paintGaussian(src, dest, amount) {
		var ctx = dest.getContext('2d');
		ctx.filter = 'none';
		if (amount < 0.5) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		sizeTo(temp, src.width, src.height);
		var blurCtx = temp.getContext('2d');
		blurCtx.filter = 'blur(' + amount + 'px)';
		blurCtx.drawImage(src, 0, 0);
		blurCtx.filter = 'none';
		ctx.drawImage(temp, 0, 0);
	}

	function paintPixel(src, dest, amount) {
		var ctx = dest.getContext('2d');
		var w = src.width;
		var h = src.height;
		if (amount <= 1) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		var sw = Math.max(1, Math.round(w / amount));
		var sh = Math.max(1, Math.round(h / amount));
		sizeTo(small, sw, sh);
		var sctx = small.getContext('2d');
		sctx.imageSmoothingEnabled = false;
		sctx.clearRect(0, 0, sw, sh);
		sctx.drawImage(src, 0, 0, sw, sh);
		ctx.imageSmoothingEnabled = false;
		ctx.drawImage(small, 0, 0, w, h);
		ctx.imageSmoothingEnabled = true;
	}

	function paintNoise(src, dest, amount) {
		var w = src.width;
		var h = src.height;
		var ctx = dest.getContext('2d');
		if (amount < 1) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		var img = src.getContext('2d').getImageData(0, 0, w, h);
		var out = ctx.createImageData(w, h);
		var s = img.data;
		var o = out.data;
		var radius = amount;
		var y, x, hx, hy, sx, sy, si, di;
		for (y = 0; y < h; y++) {
			for (x = 0; x < w; x++) {
				hx = hashUnit(x, y);
				hy = hashUnit(x + 17, y + 31);
				sx = clampInt(Math.round(x + (hx - 0.5) * 2 * radius), w - 1);
				sy = clampInt(Math.round(y + (hy - 0.5) * 2 * radius), h - 1);
				si = (sy * w + sx) * 4;
				di = (y * w + x) * 4;
				o[di] = s[si];
				o[di + 1] = s[si + 1];
				o[di + 2] = s[si + 2];
				o[di + 3] = s[si + 3];
			}
		}
		ctx.putImageData(out, 0, 0);
	}

	function paintMotion(src, dest, amount) {
		var w = src.width;
		var h = src.height;
		var ctx = dest.getContext('2d');
		var radius = Math.round(amount);
		if (radius < 1) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		var img = src.getContext('2d').getImageData(0, 0, w, h);
		var out = ctx.createImageData(w, h);
		var s = img.data;
		var o = out.data;
		var y, x, rs, gs, bs, as, count, add, rem, ai, ri, di;
		for (y = 0; y < h; y++) {
			rs = 0;
			gs = 0;
			bs = 0;
			as = 0;
			count = 0;
			for (x = 0; x <= radius && x < w; x++) {
				ai = (y * w + x) * 4;
				rs += s[ai];
				gs += s[ai + 1];
				bs += s[ai + 2];
				as += s[ai + 3];
				count++;
			}
			for (x = 0; x < w; x++) {
				di = (y * w + x) * 4;
				o[di] = rs / count;
				o[di + 1] = gs / count;
				o[di + 2] = bs / count;
				o[di + 3] = as / count;
				add = x + radius + 1;
				rem = x - radius;
				if (add < w) {
					ai = (y * w + add) * 4;
					rs += s[ai];
					gs += s[ai + 1];
					bs += s[ai + 2];
					as += s[ai + 3];
					count++;
				}
				if (rem >= 0) {
					ri = (y * w + rem) * 4;
					rs -= s[ri];
					gs -= s[ri + 1];
					bs -= s[ri + 2];
					as -= s[ri + 3];
					count--;
				}
			}
		}
		ctx.putImageData(out, 0, 0);
	}

	function paintRadial(src, dest, amount) {
		var w = src.width;
		var h = src.height;
		var ctx = dest.getContext('2d');
		if (amount < 1) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		var img = src.getContext('2d').getImageData(0, 0, w, h);
		var out = ctx.createImageData(w, h);
		var s = img.data;
		var o = out.data;
		var cx = (w - 1) / 2;
		var cy = (h - 1) / 2;
		var steps = 5;
		var y, x, dx, dy, len, ux, uy, i, dist, sx, sy, si, di, r, g, b, a;
		for (y = 0; y < h; y++) {
			for (x = 0; x < w; x++) {
				dx = x - cx;
				dy = y - cy;
				len = Math.sqrt(dx * dx + dy * dy) || 1;
				ux = dx / len;
				uy = dy / len;
				r = 0;
				g = 0;
				b = 0;
				a = 0;
				for (i = 0; i < steps; i++) {
					dist = (i / (steps - 1)) * amount;
					sx = clampInt(x - ux * dist, w - 1) | 0;
					sy = clampInt(y - uy * dist, h - 1) | 0;
					si = (sy * w + sx) * 4;
					r += s[si];
					g += s[si + 1];
					b += s[si + 2];
					a += s[si + 3];
				}
				di = (y * w + x) * 4;
				o[di] = r / steps;
				o[di + 1] = g / steps;
				o[di + 2] = b / steps;
				o[di + 3] = a / steps;
			}
		}
		ctx.putImageData(out, 0, 0);
	}

	function paintColor(src, dest, amount) {
		var w = src.width;
		var h = src.height;
		var ctx = dest.getContext('2d');
		var distance = Math.round(amount);
		if (distance < 1) {
			ctx.drawImage(src, 0, 0);
			return;
		}
		var img = src.getContext('2d').getImageData(0, 0, w, h);
		var out = ctx.createImageData(w, h);
		var s = img.data;
		var o = out.data;
		var steps = 5;
		var y, x, i, t, xr, xb, yg, r, g, b, a, di;
		for (y = 0; y < h; y++) {
			for (x = 0; x < w; x++) {
				r = 0;
				g = 0;
				b = 0;
				a = 0;
				for (i = 0; i < steps; i++) {
					t = (i / (steps - 1) - 0.5) * 2;
					xr = clampInt(Math.round(x + t * distance), w - 1);
					xb = clampInt(Math.round(x - t * distance), w - 1);
					yg = clampInt(Math.round(y + t * distance * 0.35), h - 1);
					r += s[(y * w + xr) * 4];
					g += s[(yg * w + x) * 4 + 1];
					b += s[(y * w + xb) * 4 + 2];
					a += s[(y * w + x) * 4 + 3];
				}
				di = (y * w + x) * 4;
				o[di] = r / steps;
				o[di + 1] = g / steps;
				o[di + 2] = b / steps;
				o[di + 3] = a / steps;
			}
		}
		ctx.putImageData(out, 0, 0);
	}

	function paintEffect(src, dest, scale) {
		var amount = Number(strengths[effectName] || 0) * (scale || 1);
		sizeTo(dest, src.width, src.height);
		if (effectName === 'pixel') paintPixel(src, dest, amount);
		else if (effectName === 'noise') paintNoise(src, dest, amount);
		else if (effectName === 'motion') paintMotion(src, dest, amount);
		else if (effectName === 'radial') paintRadial(src, dest, amount);
		else if (effectName === 'color') paintColor(src, dest, amount);
		else paintGaussian(src, dest, amount);
	}

	function paintWhole(src, dest, referenceEdge) {
		var scale = referenceEdge ? Math.max(src.width, src.height) / referenceEdge : 1;
		paintEffect(src, dest, scale);
	}

	function renderBatch() {
		var referenceEdge = batchReferenceEdge();
		batchItems.forEach(function (item) {
			paintWhole(item.source, item.preview, referenceEdge);
		});
	}

	function buildEffect() {
		var key = effectCacheKey();
		if (key === effectKey) return;
		effectKey = key;
		var w = source.width;
		var h = source.height;
		var ctx = effect.getContext('2d');
		ctx.clearRect(0, 0, w, h);
		ctx.filter = 'none';

		if (mode === 'unblur') {
			var amount = Number(sharpen.value) / 100;
			var rad = Number(radius.value);
			var c = Number(contrast.value);
			var bctx = temp.getContext('2d');
			bctx.clearRect(0, 0, w, h);
			bctx.filter = 'blur(' + rad + 'px)';
			bctx.drawImage(source, 0, 0);
			bctx.filter = 'none';
			var srcData = source.getContext('2d').getImageData(0, 0, w, h);
			var blurData = bctx.getImageData(0, 0, w, h);
			var out = ctx.createImageData(w, h);
			var factor = (259 * (c + 255)) / (255 * (259 - c));
			var s = srcData.data;
			var b = blurData.data;
			var o = out.data;
			for (var i = 0; i < o.length; i += 4) {
				for (var k = 0; k < 3; k++) {
					var v = s[i + k] + amount * (s[i + k] - b[i + k]);
					v = factor * (v - 128) + 128;
					o[i + k] = v < 0 ? 0 : (v > 255 ? 255 : v);
				}
				o[i + 3] = s[i + 3];
			}
			ctx.putImageData(out, 0, 0);
			return;
		}

		paintEffect(source, effect, 1);
	}

	function render() {
		if (!ready) return;
		buildEffect();
		var w = source.width;
		var h = source.height;
		var rctx = result.getContext('2d');
		rctx.clearRect(0, 0, w, h);
		rctx.globalCompositeOperation = 'source-over';
		if (mode === 'blur' && scopeName !== 'whole') {
			rctx.drawImage(source, 0, 0);
			var tctx = temp.getContext('2d');
			tctx.save();
			tctx.clearRect(0, 0, w, h);
			tctx.globalCompositeOperation = 'source-over';
			tctx.drawImage(effect, 0, 0);
			tctx.globalCompositeOperation = 'destination-in';
			tctx.drawImage(mask, 0, 0);
			tctx.restore();
			rctx.drawImage(temp, 0, 0);
		} else {
			rctx.drawImage(effect, 0, 0);
		}
		paintView();
	}

	function requestRender() {
		cancelAnimationFrame(frame);
		frame = requestAnimationFrame(function () {
			if (jobName === 'batch') renderBatch();
			else render();
		});
	}

	function paintView() {
		var ctx = view.getContext('2d');
		ctx.clearRect(0, 0, view.width, view.height);
		ctx.drawImage(showingOriginal ? source : result, 0, 0);
	}

	function pointFromEvent(event) {
		var rect = ink.getBoundingClientRect();
		return {
			x: (event.clientX - rect.left) * (ink.width / rect.width),
			y: (event.clientY - rect.top) * (ink.height / rect.height)
		};
	}

	function strokeTo(x, y) {
		if (!strokeDraft) return;
		var pts = strokeDraft.points;
		if (strokeDraft.kind === 'marquee') {
			if (!pts.length) pts.push({ x: x, y: y });
			else pts[1] = { x: x, y: y };
			redrawMask();
			return;
		}
		var prev = pts.length ? pts[pts.length - 1] : null;
		if (prev && prev.x === x && prev.y === y) return;
		pts.push({ x: x, y: y });
		redrawMask();
	}

	function scaledSource(img) {
		var maxEdge = 1600;
		var scale = Math.min(1, maxEdge / Math.max(img.width, img.height));
		var canvas = document.createElement('canvas');
		canvas.width = Math.max(1, Math.round(img.width * scale));
		canvas.height = Math.max(1, Math.round(img.height * scale));
		canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
		return canvas;
	}

	function clearBatch() {
		batchItems = [];
		if (batchBox) batchBox.innerHTML = '';
	}

	function clearSingleWork() {
		ready = false;
		strokes = [];
		strokeDraft = null;
		history = [];
		historyAt = -1;
		showingOriginal = false;
		clearMask();
		stage.hidden = true;
		zoomBar.hidden = true;
		replaceBtn.hidden = true;
		downloadBtn.disabled = true;
		originalBtn.disabled = true;
		updateHistoryButtons();
	}

	function batchStatus() {
		var count = batchItems.length;
		setStatus(count + (count === 1 ? ' image' : ' images') + '. Before and After use one strength, matched to the largest photo.');
	}

	function removeBatchItem(item, figure) {
		batchItems = batchItems.filter(function (entry) { return entry !== item; });
		figure.remove();
		if (!batchItems.length) {
			clearBatch();
			dropzone.hidden = false;
			replaceBtn.hidden = true;
			downloadBtn.disabled = true;
			syncJob();
			setStatus('Batch is empty. Add images to blur them together.');
			return;
		}
		batchStatus();
	}

	function batchPane(canvas, label) {
		var figure = document.createElement('figure');
		var caption = document.createElement('figcaption');
		caption.textContent = label;
		figure.appendChild(canvas);
		figure.appendChild(caption);
		return figure;
	}

	function addBatchFigure(item) {
		var article = document.createElement('article');
		var meta = document.createElement('div');
		var name = document.createElement('span');
		var size = document.createElement('span');
		var remove = document.createElement('button');
		var pair = document.createElement('div');
		article.className = 'batch-item';
		meta.className = 'batch-meta';
		name.className = 'batch-name';
		name.textContent = item.name;
		name.title = item.name;
		size.className = 'batch-size';
		size.textContent = item.source.width + ' × ' + item.source.height;
		remove.type = 'button';
		remove.className = 'batch-remove';
		remove.textContent = 'Remove';
		remove.addEventListener('click', function () { removeBatchItem(item, article); });
		meta.appendChild(name);
		meta.appendChild(size);
		meta.appendChild(remove);
		pair.className = 'batch-pair';
		pair.appendChild(batchPane(item.source, 'Before'));
		pair.appendChild(batchPane(item.preview, 'After'));
		article.appendChild(meta);
		article.appendChild(pair);
		batchBox.appendChild(article);
	}

	function showBatch() {
		dropzone.hidden = true;
		batchBox.hidden = false;
		stage.hidden = true;
		zoomBar.hidden = true;
		downloadBtn.disabled = false;
		originalBtn.disabled = true;
		renderBatch();
		syncJob();
		batchStatus();
	}

	function loadFiles(list) {
		var files = [];
		var i;
		for (i = 0; i < list.length; i++) {
			if (list[i] && list[i].type.indexOf('image/') === 0) files.push(list[i]);
		}
		if (!files.length) {
			setStatus('Choose a JPG, PNG, or WEBP image.');
			return;
		}
		if (jobName !== 'batch') {
			loadFile(files[0], files.length > 1 ? 'Loaded the first image. Switch to Batch to blur every file.' : '');
			return;
		}
		var appending = batchAppend || batchItems.length > 0;
		batchAppend = false;
		var room = BATCH_LIMIT - (appending ? batchItems.length : 0);
		if (room <= 0) {
			setStatus('This batch already has ' + BATCH_LIMIT + ' images.');
			return;
		}
		var skipped = 0;
		if (files.length > room) {
			skipped = files.length - room;
			files = files.slice(0, room);
		}
		if (!appending) clearBatch();
		var token = ++loadToken;
		var slots = new Array(files.length);
		var left = files.length;
		files.forEach(function (file, index) {
			var url = URL.createObjectURL(file);
			var img = new Image();
			img.onload = function () {
				URL.revokeObjectURL(url);
				if (token !== loadToken) return;
				var sourceCanvas = scaledSource(img);
				var preview = document.createElement('canvas');
				slots[index] = { name: file.name, source: sourceCanvas, preview: preview };
				left--;
				if (left === 0) finishBatch(slots, skipped, appending);
			};
			img.onerror = function () {
				URL.revokeObjectURL(url);
				if (token !== loadToken) return;
				left--;
				if (left === 0) finishBatch(slots, skipped, appending);
			};
			img.src = url;
		});
	}

	function finishBatch(slots, skipped, appending) {
		var added = slots.filter(Boolean);
		if (!appending) {
			batchItems = [];
			batchBox.innerHTML = '';
		}
		added.forEach(function (item) {
			batchItems.push(item);
			addBatchFigure(item);
		});
		if (!batchItems.length) {
			dropzone.hidden = false;
			setStatus('This browser could not read those files. Try JPG or PNG.');
			return;
		}
		showBatch();
		if (skipped) setStatus('Stopped at ' + BATCH_LIMIT + ' images. ' + skipped + ' more were left out.');
	}

	function chooseJob(name) {
		if (!batchEnabled || jobName === name) return;
		loadToken++;
		jobName = name;
		clearSingleWork();
		clearBatch();
		dropzone.hidden = false;
		batchBox.hidden = true;
		syncJob();
		setStatus(name === 'batch'
			? 'Batch blurs up to 12 whole images with one setting, then downloads a zip.'
			: 'Single image. Use Brush when only part of the photo should change.');
	}

	fileInput.addEventListener('change', function () {
		if (fileInput.files && fileInput.files.length) loadFiles(fileInput.files);
		else batchAppend = false;
		fileInput.value = '';
	});
	replaceBtn.addEventListener('click', function () {
		batchAppend = false;
		fileInput.click();
	});
	if (batchAddBtn) batchAddBtn.addEventListener('click', function () {
		batchAppend = true;
		fileInput.click();
	});
	if (batchClearBtn) batchClearBtn.addEventListener('click', function () {
		loadToken++;
		batchAppend = false;
		clearBatch();
		dropzone.hidden = false;
		batchBox.hidden = true;
		downloadBtn.disabled = true;
		syncJob();
		setStatus('Batch is empty. Add images to blur them together.');
	});
	if (sampleBtn) sampleBtn.addEventListener('click', loadSample);
	undoBtn.addEventListener('click', undo);
	redoBtn.addEventListener('click', redo);
	resetBtn.addEventListener('click', restoreImage);

	[intensity, brush, sharpen, radius, contrast].forEach(function (input) {
		input.addEventListener('input', function () {
			if (input === intensity) strengths[effectName] = Number(intensity.value);
			syncLabels();
			requestRender();
		});
		input.addEventListener('change', commitSettings);
	});

	function chooseEffect(name) {
		if (effectName === name) return;
		effectName = name;
		syncLabels();
		requestRender();
		commitSettings();
	}
	function chooseScope(name) {
		if (jobName === 'batch' || scopeName === name) return;
		scopeName = name;
		syncLabels();
		requestRender();
		commitSettings();
		if (name === 'marquee') setStatus('Drag a rectangle. The blur stays inside it.');
		else if (name === 'lasso') setStatus('Draw around an area and release. The blur stays inside that shape.');
		else if (name === 'brush') setStatus('Paint where the blur should appear.');
	}
	effectNames.forEach(function (name) {
		if (effectButtons[name]) effectButtons[name].addEventListener('click', function () { chooseEffect(name); });
	});
	scopeWholeBtn.addEventListener('click', function () { chooseScope('whole'); });
	scopeBrushBtn.addEventListener('click', function () { chooseScope('brush'); });
	if (scopeMarqueeBtn) scopeMarqueeBtn.addEventListener('click', function () { chooseScope('marquee'); });
	if (scopeLassoBtn) scopeLassoBtn.addEventListener('click', function () { chooseScope('lasso'); });

	editor.addEventListener('dragover', function (event) {
		event.preventDefault();
		dropzone.classList.add('hot');
	});
	editor.addEventListener('dragleave', function () { dropzone.classList.remove('hot'); });
	editor.addEventListener('drop', function (event) {
		event.preventDefault();
		dropzone.classList.remove('hot');
		if (event.dataTransfer.files.length) loadFiles(event.dataTransfer.files);
	});

	function onScrollbar(event) {
		return event.target === stageViewport
			&& (event.offsetX >= stageViewport.clientWidth || event.offsetY >= stageViewport.clientHeight);
	}

	function startPan(event) {
		panning = true;
		painting = false;
		stage.classList.add('is-panning');
		panStart = {
			x: event.clientX,
			y: event.clientY,
			left: stageViewport.scrollLeft,
			top: stageViewport.scrollTop
		};
		try { stageViewport.setPointerCapture(event.pointerId); } catch (err) {}
	}

	function stopPaint() {
		if (painting && selectionUseful(strokeDraft)) {
			strokes.push(strokeDraft);
			pushHistory();
		}
		strokeDraft = null;
		painting = false;
		panning = false;
		panStart = null;
		stage.classList.remove('is-panning');
	}

	stageViewport.addEventListener('mousedown', function (event) {
		if (event.button === 1) event.preventDefault();
	});
	stageViewport.addEventListener('pointerdown', function (event) {
		if (!ready || onScrollbar(event)) return;
		var canPan = zoom > 1 && (event.button === 1 || (spaceDown && event.button === 0));
		if (canPan) {
			startPan(event);
			event.preventDefault();
			return;
		}
		if (event.button !== 0) return;
		if (mode !== 'blur' || scopeName === 'whole') return;
		if (event.target !== ink) return;
		painting = true;
		strokeDraft = {
			kind: scopeName === 'marquee' || scopeName === 'lasso' ? scopeName : 'brush',
			size: Number(brush.value),
			points: []
		};
		if (effectIdle()) {
			setStatus('Raise Strength to see the blur. At the minimum the photo stays unchanged.');
		}
		try { stageViewport.setPointerCapture(event.pointerId); } catch (err) {}
		var p = pointFromEvent(event);
		strokeTo(p.x, p.y);
		requestRender();
	});
	stageViewport.addEventListener('pointermove', function (event) {
		if (panning && panStart) {
			stageViewport.scrollLeft = panStart.left - (event.clientX - panStart.x);
			stageViewport.scrollTop = panStart.top - (event.clientY - panStart.y);
			return;
		}
		if (!painting) return;
		var p = pointFromEvent(event);
		strokeTo(p.x, p.y);
		requestRender();
	});
	stageViewport.addEventListener('pointerup', stopPaint);
	stageViewport.addEventListener('pointercancel', stopPaint);
	stageViewport.addEventListener('wheel', function (event) {
		if (mode !== 'blur' || !ready) return;
		event.preventDefault();
		var delta = event.deltaY;
		if (event.deltaMode === 1) delta *= 16;
		else if (event.deltaMode === 2) delta *= stageViewport.clientHeight;
		setZoom(zoom * 100 * Math.exp(-delta * 0.002), { x: event.clientX, y: event.clientY });
	}, { passive: false });

	zoomInput.addEventListener('input', function () {
		zoom = Number(zoomInput.value) / 100;
		layoutStage();
		updateZoomControls();
	});
	zoomOutBtn.addEventListener('click', function () { setZoom(zoom * 100 - 25); });
	zoomInBtn.addEventListener('click', function () { setZoom(zoom * 100 + 25); });
	zoomFitBtn.addEventListener('click', function () { setZoom(100); });

	function keyTargetIsControl(event) {
		var tag = event.target && event.target.tagName;
		return tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'BUTTON' || tag === 'A' || tag === 'SELECT';
	}
	document.addEventListener('keydown', function (event) {
		if ((event.ctrlKey || event.metaKey) && !event.altKey) {
			var key = event.key.toLowerCase();
			if (key === 'z') {
				event.preventDefault();
				if (event.shiftKey) redo();
				else undo();
				return;
			}
			if (key === 'y') {
				event.preventDefault();
				redo();
				return;
			}
		}
		if (mode !== 'blur' || keyTargetIsControl(event)) return;
		if (event.code === 'Space') {
			spaceDown = true;
			stage.classList.add('is-space');
			event.preventDefault();
			return;
		}
		if (!ready) return;
		if (event.key === '+' || event.key === '=') {
			event.preventDefault();
			setZoom(zoom * 100 + 25);
		} else if (event.key === '-' || event.key === '_') {
			event.preventDefault();
			setZoom(zoom * 100 - 25);
		} else if (event.key === '0') {
			event.preventDefault();
			setZoom(100);
		}
	});
	document.addEventListener('keyup', function (event) {
		if (event.code !== 'Space') return;
		spaceDown = false;
		stage.classList.remove('is-space');
	});
	window.addEventListener('resize', function () {
		if (ready) layoutStage();
	});

	function showOriginal(on) {
		showingOriginal = on;
		if (ready) paintView();
	}
	originalBtn.addEventListener('pointerdown', function () { showOriginal(true); });
	originalBtn.addEventListener('pointerup', function () { showOriginal(false); });
	originalBtn.addEventListener('pointerleave', function () { showOriginal(false); });
	originalBtn.addEventListener('keyup', function (event) {
		if (event.key === ' ' || event.key === 'Enter') showOriginal(false);
	});
	originalBtn.addEventListener('keydown', function (event) {
		if (event.key === ' ' || event.key === 'Enter') {
			event.preventDefault();
			showOriginal(true);
		}
	});

	function crc32(data) {
		var table = crc32.table;
		if (!table) {
			table = new Uint32Array(256);
			for (var n = 0; n < 256; n++) {
				var c = n;
				for (var k = 0; k < 8; k++) c = (c & 1) ? (0xedb88320 ^ (c >>> 1)) : (c >>> 1);
				table[n] = c >>> 0;
			}
			crc32.table = table;
		}
		var crc = 0xffffffff;
		for (var i = 0; i < data.length; i++) crc = table[(crc ^ data[i]) & 0xff] ^ (crc >>> 8);
		return (crc ^ 0xffffffff) >>> 0;
	}

	function zipStore(files) {
		var now = new Date();
		var dosTime = (now.getHours() << 11) | (now.getMinutes() << 5) | (now.getSeconds() >> 1);
		var dosDate = ((now.getFullYear() - 1980) << 9) | ((now.getMonth() + 1) << 5) | now.getDate();
		var parts = [];
		var central = [];
		var offset = 0;
		files.forEach(function (file) {
			var nameBytes = new TextEncoder().encode(file.name);
			var crc = crc32(file.bytes);
			var local = new DataView(new ArrayBuffer(30));
			local.setUint32(0, 0x04034b50, true);
			local.setUint16(4, 20, true);
			local.setUint16(6, 0x0800, true);
			local.setUint16(8, 0, true);
			local.setUint16(10, dosTime, true);
			local.setUint16(12, dosDate, true);
			local.setUint32(14, crc, true);
			local.setUint32(18, file.bytes.length, true);
			local.setUint32(22, file.bytes.length, true);
			local.setUint16(26, nameBytes.length, true);
			parts.push(new Uint8Array(local.buffer), nameBytes, file.bytes);
			var cen = new DataView(new ArrayBuffer(46));
			cen.setUint32(0, 0x02014b50, true);
			cen.setUint16(4, 20, true);
			cen.setUint16(6, 20, true);
			cen.setUint16(8, 0x0800, true);
			cen.setUint16(10, 0, true);
			cen.setUint16(12, dosTime, true);
			cen.setUint16(14, dosDate, true);
			cen.setUint32(16, crc, true);
			cen.setUint32(20, file.bytes.length, true);
			cen.setUint32(24, file.bytes.length, true);
			cen.setUint16(28, nameBytes.length, true);
			cen.setUint32(42, offset, true);
			central.push(new Uint8Array(cen.buffer), nameBytes);
			offset += 30 + nameBytes.length + file.bytes.length;
		});
		var centralSize = 0;
		central.forEach(function (part) { centralSize += part.length; });
		var end = new DataView(new ArrayBuffer(22));
		end.setUint32(0, 0x06054b50, true);
		end.setUint16(8, files.length, true);
		end.setUint16(10, files.length, true);
		end.setUint32(12, centralSize, true);
		end.setUint32(16, offset, true);
		return new Blob(parts.concat(central, [new Uint8Array(end.buffer)]), { type: 'application/zip' });
	}

	function saveBlob(blob, filename) {
		var link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = filename;
		link.click();
		setTimeout(function () { URL.revokeObjectURL(link.href); }, 1500);
	}

	function batchDownloadName(name, used) {
		var base = String(name || 'image').replace(/\.[^.]+$/, '').replace(/[\\/:*?"<>|]/g, '-');
		if (!base) base = 'image';
		var filename = base + '-blurred.png';
		var n = 2;
		while (used[filename]) {
			filename = base + '-' + n + '-blurred.png';
			n++;
		}
		used[filename] = true;
		return filename;
	}

	function downloadBatch() {
		if (!batchItems.length) return;
		downloadBtn.disabled = true;
		setStatus('Preparing ' + batchItems.length + ' images.');
		var files = new Array(batchItems.length);
		var left = batchItems.length;
		var used = {};
		batchItems.forEach(function (item, index) {
			var full = document.createElement('canvas');
			paintWhole(item.source, full, batchReferenceEdge());
			full.toBlob(function (blob) {
				if (!blob) {
					left--;
					if (left === 0) finishZip(files);
					return;
				}
				var reader = new FileReader();
				reader.onload = function () {
					files[index] = { name: batchDownloadName(item.name, used), bytes: new Uint8Array(reader.result) };
					left--;
					if (left === 0) finishZip(files);
				};
				reader.readAsArrayBuffer(blob);
			}, 'image/png');
		});
		function finishZip(entries) {
			var readyFiles = entries.filter(Boolean);
			downloadBtn.disabled = false;
			if (!readyFiles.length) {
				setStatus('The browser could not prepare those images.');
				return;
			}
			saveBlob(zipStore(readyFiles), 'blurred-images.zip');
			setStatus('Downloaded ' + readyFiles.length + ' images in blurred-images.zip.');
		}
	}

	downloadBtn.addEventListener('click', function () {
		if (jobName === 'batch') {
			downloadBatch();
			return;
		}
		if (!ready) return;
		result.toBlob(function (blob) {
			if (!blob) return;
			saveBlob(blob, mode === 'unblur' ? 'unblurred-photo.png' : 'blurred-image.png');
		}, 'image/png');
	});

	if (jobSingleBtn) jobSingleBtn.addEventListener('click', function () { chooseJob('single'); });
	if (jobBatchBtn) jobBatchBtn.addEventListener('click', function () { chooseJob('batch'); });

	applyPreset();
	updateZoomControls();
	syncJob();
	setStatus('Click or drag an image here. Editing stays in this browser.');
})();
