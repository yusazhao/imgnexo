(function () {
	var editor = document.getElementById('editor');
	if (!editor) return;

	var mode = editor.getAttribute('data-mode');
	var presetName = editor.getAttribute('data-preset') || (mode === 'unblur' ? 'sharpen' : 'soft');
	var presets = {
		soft: { effect: 'gaussian', gaussian: 0, pixel: 1, scope: 'brush', brush: 48 },
		background: { effect: 'gaussian', gaussian: 18, pixel: 12, scope: 'brush', brush: 72 },
		face: { effect: 'pixel', gaussian: 4, pixel: 16, scope: 'brush', brush: 46 },
		text: { effect: 'pixel', gaussian: 14, pixel: 16, scope: 'marquee', brush: 26 },
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
	var subjectMode = editor.getAttribute('data-subject') === '1';
	var faceMode = editor.getAttribute('data-face') === '1';
	var textMode = editor.getAttribute('data-text') === '1';
	var effectPage = editor.getAttribute('data-effects') === '1';
	var subjectAutoBtn = document.getElementById('subject-auto');
	var feather = document.getElementById('feather');
	var featherGroup = document.getElementById('feather-group');
	var subjectAuto = subjectMode;
	var maskOp = 'keep';
	var maskShown = false;
	var maskToggle = document.getElementById('mask-toggle');
	var refineKeepBtn = document.getElementById('refine-keep');
	var refineEraseBtn = document.getElementById('refine-erase');
	var protectLifeBtn = document.getElementById('protect-life');
	var protectThingsBtn = document.getElementById('protect-things');
	var blurBgBtn = document.getElementById('blur-background');
	var autoProgress = document.getElementById('auto-progress');
	var autoProgressBar = document.getElementById('auto-progress-bar');
	var autoProgressLabel = document.getElementById('auto-progress-label');
	var effectNames = ['gaussian', 'pixel', 'noise', 'motion', 'radial', 'color', 'bar', 'gray'];
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
	var frameSwitch = document.getElementById('frame-switch');
	var frameButtons = frameSwitch.querySelectorAll('[data-frame]');
	var cropLayer = document.getElementById('crop-layer');
	var cropFrame = document.getElementById('crop-frame');
	var cropTag = document.getElementById('crop-tag');
	var cropShades = {
		top: document.getElementById('crop-top'),
		left: document.getElementById('crop-left'),
		right: document.getElementById('crop-right'),
		bottom: document.getElementById('crop-bottom')
	};
	var cropRatios = { '9:16': [9, 16], '3:4': [3, 4], '4:5': [4, 5], '1:1': [1, 1], '16:9': [16, 9] };
	var cropName = 'original';
	var cropX = 0;
	var cropY = 0;
	var cropW = 0;
	var cropH = 0;
	var cropDrag = null;
	var cropResize = null;
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
	var FILE_LIMIT = 15 * 1024 * 1024;
	var WORK_EDGE = 1600;

	var source = document.createElement('canvas');
	var effect = document.createElement('canvas');
	var result = document.createElement('canvas');
	var mask = document.createElement('canvas');
	var shape = document.createElement('canvas');
	var eraseShape = document.createElement('canvas');
	var maskTint = document.createElement('canvas');
	var temp = document.createElement('canvas');
	var featherPad = document.createElement('canvas');
	var featherBlur = document.createElement('canvas');
	var autoShape = document.createElement('canvas');
	var small = document.createElement('canvas');
	var categoryCache = null;
	var thingCache = null;
	var autoHasPixels = false;
	var protectMode = 'life';
	var autoBusy = false;
	var autoToken = 0;
	var segmenter = null;
	var segmenterPromise = null;
	var thingSession = null;
	var thingSessionPromise = null;
	var thingTensor = null;
	var LIFE_CLASSES = { 3: 1, 8: 1, 10: 1, 12: 1, 13: 1, 15: 1, 17: 1 };
	var faceBoxes = [];
	var faceBusy = false;
	var faceDetector = null;
	var faceDetectorNear = null;
	var faceDetectorPromise = null;
	var faceLayer = document.getElementById('face-layer');
	var blurFacesBtn = document.getElementById('blur-faces');
	var strengthGroup = document.getElementById('strength-group');
	var FACE_MIN_SCORE = 0.34;
	var textBoxes = [];
	var textBusy = false;
	var textWorker = null;
	var textWorkerPromise = null;
	var textLayer = document.getElementById('text-layer');
	var blurTextAllBtn = document.getElementById('blur-text-all');
	var blurTextSensitiveBtn = document.getElementById('blur-text-sensitive');
	var redactTones = document.getElementById('redact-tones');
	var redactBlackBtn = document.getElementById('redact-black');
	var redactGrayBtn = document.getElementById('redact-gray');
	var motionGroup = document.getElementById('motion-group');
	var motionAngleInput = document.getElementById('motion-angle');
	var radialHint = document.getElementById('radial-hint');
	var intensityName = document.getElementById('intensity-name');
	var focusLayer = document.getElementById('focus-layer');
	var focusPoint = document.getElementById('focus-point');
	var motionAngle = 0;
	var radialX = 0.5;
	var radialY = 0.5;
	var focusDrag = false;
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
	var strengths = { gaussian: 0, pixel: 1, noise: 0, motion: 0, radial: 0, color: 0, bar: 1, gray: 1 };

	Array.prototype.forEach.call(editor.querySelectorAll('[data-for]'), function (el) {
		el.hidden = el.getAttribute('data-for') !== mode;
	});

	function applyPreset() {
		var preset = presets[presetName] || presets.soft;
		if (mode === 'blur') {
			effectName = strengths[preset.effect] != null ? preset.effect : 'gaussian';
			strengths.gaussian = preset.gaussian;
			strengths.pixel = preset.pixel;
			if (preset.scope === 'brush' || preset.scope === 'marquee' || preset.scope === 'lasso') scopeName = preset.scope;
			else scopeName = 'whole';
			brush.value = preset.brush;
			if (feather && !subjectMode) feather.value = '0';
			if (subjectMode) {
				subjectAuto = true;
				maskOp = 'keep';
				if (feather) feather.value = '16';
				['motion', 'radial', 'color'].forEach(function (name) {
					if (effectButtons[name]) effectButtons[name].hidden = true;
				});
				if (scopeWholeBtn) scopeWholeBtn.hidden = true;
			}
		} else {
			sharpen.value = preset.sharpen;
			radius.value = preset.radius;
			contrast.value = preset.contrast;
		}
		syncLabels();
	}

	function effectIdle() {
		if (effectName === 'bar' || effectName === 'gray') return false;
		var amount = Number(strengths[effectName] || 0);
		return effectName === 'pixel' ? amount <= 1 : amount <= 0;
	}

	function syncLabels() {
		var strength = Number(strengths[effectName] || 0);
		intensity.min = effectName === 'pixel' ? '1' : '0';
		intensity.max = '40';
		intensity.value = String(strength);
		document.getElementById('intensity-out').textContent = (effectName === 'pixel' && strength <= 1) ? 'off' : strength + ' px';
		if (strengthGroup && !effectPage) strengthGroup.hidden = effectName === 'bar' || effectName === 'gray';
		if (intensityName) {
			intensityName.textContent = effectName === 'pixel' ? 'Block Size' : effectName === 'motion' ? 'Speed' : effectName === 'radial' ? 'Blur Radius' : 'Strength';
		}
		if (motionAngleInput) {
			motionAngleInput.value = String(motionAngle);
			document.getElementById('motion-angle-out').textContent = motionAngle + '°';
		}
		document.getElementById('brush-out').textContent = brush.value + ' px';
		document.getElementById('zoom-out').textContent = Math.round(zoom * 100) + '%';
		document.getElementById('sharpen-out').textContent = (Number(sharpen.value) / 100).toFixed(2);
		document.getElementById('radius-out').textContent = Number(radius.value).toFixed(1) + ' px';
		document.getElementById('contrast-out').textContent = contrast.value;
		if (feather) document.getElementById('feather-out').textContent = feather.value + ' px';
		if (subjectAutoBtn) setChoice(subjectAutoBtn, subjectAuto);
		syncProtectChoices();
		syncRefine();
		syncScope();
		syncTextStyle();
		syncEffectControls();
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
		if (featherGroup && !subjectMode) featherGroup.hidden = !regional;
		stage.classList.toggle('is-region', regional);
		ink.style.visibility = regional ? 'visible' : 'hidden';
	}

	function syncJob() {
		if (!batchEnabled) return;
		var batch = jobName === 'batch';
		setChoice(jobSingleBtn, !batch);
		setChoice(jobBatchBtn, batch);
		fileInput.multiple = batch;
		historyBar.hidden = batch || !ready;
		if (sampleBtn) sampleBtn.hidden = batch;
		originalBtn.hidden = batch;
		if (editorNote && editorNote.getAttribute('data-batch')) {
			editorNote.textContent = batch ? editorNote.getAttribute('data-batch') : editorNote.getAttribute('data-single');
		}
		if (dropTitle) dropTitle.textContent = batch ? 'Click or drag images here' : 'Click or drag an image here';
		if (selectBtn) selectBtn.textContent = batch ? 'Select images' : 'Select image';
		replaceBtn.textContent = 'Replace';
		downloadBtn.textContent = batch ? 'Download all' : 'Download';
		placeCrop();
		syncAutoButton();
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
		var scale = Math.min(1, WORK_EDGE / Math.max(img.width, img.height));
		var w = Math.max(1, Math.round(img.width * scale));
		var h = Math.max(1, Math.round(img.height * scale));
		[source, effect, result, mask, shape, eraseShape, maskTint, temp, view, ink, autoShape].forEach(function (canvas) {
			sizeTo(canvas, w, h);
		});
		autoToken++;
		autoBusy = false;
		categoryCache = null;
		thingCache = null;
		autoHasPixels = false;
		maskShown = false;
		setAutoProgress(false, 0, '');
		effectKey = '';
		source.getContext('2d').drawImage(img, 0, 0, w, h);
		faceBusy = false;
		textBusy = false;
		ready = true;
		editor.classList.add('is-editing');
		dropzone.hidden = true;
		stage.hidden = false;
		historyBar.hidden = false;
		replaceBtn.hidden = false;
		downloadBtn.disabled = false;
		originalBtn.disabled = false;
		zoom = 1;
		zoomInput.value = '100';
		zoomBar.hidden = mode !== 'blur';
		strokes = [];
		strokeDraft = null;
		faceBoxes = [];
		placeFaceBoxes();
		textBoxes = [];
		placeTextBoxes();
		history = [];
		historyAt = -1;
		clearMask();
		pushHistory();
		layoutStage();
		requestRender();
		syncJob();
		syncAutoButton();
		syncFaceButton();
		syncTextButtons();
		syncRefine();
		if (cropName !== 'original') centerCrop();
		placeCrop();
		placeFocus();
	}

	function maxViewportHeight() {
		if (window.matchMedia('(max-width: 900px)').matches) return Math.round(window.innerHeight * 0.42);
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
		var narrow = window.matchMedia('(max-width: 900px)').matches;
		var outerW = editorStage.clientWidth || editor.querySelector('.editor-layout').clientWidth;
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
		stage.style.width = narrow ? '100%' : (frameW + 'px');
		stage.style.maxWidth = '100%';
		stageViewport.style.width = '100%';
		stageViewport.style.overflowX = hugged ? 'hidden' : 'auto';
		stageViewport.style.overflowY = 'hidden';
		stageViewport.style.height = dispH + 'px';
		stageSizer.style.width = dispW + 'px';
		stageSizer.style.height = dispH + 'px';
		stageSizer.style.marginLeft = narrow ? 'auto' : '';
		stageSizer.style.marginRight = narrow ? 'auto' : '';
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

	function batchLimit() {
		return window.matchMedia('(max-width: 900px)').matches ? 6 : 12;
	}

	function releaseDecoded(image) {
		if (image && typeof image.close === 'function') image.close();
	}

	function imageSizeFromHeader(bytes) {
		if (bytes.length >= 24 && bytes[0] === 137 && bytes[1] === 80 && bytes[2] === 78 && bytes[3] === 71) {
			return {
				width: ((bytes[16] << 24) | (bytes[17] << 16) | (bytes[18] << 8) | bytes[19]) >>> 0,
				height: ((bytes[20] << 24) | (bytes[21] << 16) | (bytes[22] << 8) | bytes[23]) >>> 0
			};
		}
		if (bytes.length >= 10 && bytes[0] === 71 && bytes[1] === 73 && bytes[2] === 70) {
			return { width: bytes[6] | (bytes[7] << 8), height: bytes[8] | (bytes[9] << 8) };
		}
		if (bytes.length >= 30 && bytes[0] === 82 && bytes[1] === 73 && bytes[2] === 70 && bytes[3] === 70 && bytes[8] === 87 && bytes[9] === 69 && bytes[10] === 66 && bytes[11] === 80 && bytes[12] === 86 && bytes[13] === 80 && bytes[14] === 56 && bytes[15] === 88) {
			return {
				width: 1 + bytes[24] + (bytes[25] << 8) + (bytes[26] << 16),
				height: 1 + bytes[27] + (bytes[28] << 8) + (bytes[29] << 16)
			};
		}
		if (bytes.length < 4 || bytes[0] !== 255 || bytes[1] !== 216) return null;
		var i = 2;
		while (i < bytes.length - 8) {
			if (bytes[i] !== 255) break;
			while (i < bytes.length && bytes[i] === 255) i++;
			if (i >= bytes.length) break;
			var marker = bytes[i++];
			if (marker === 217 || marker === 218) break;
			if (marker === 1 || (marker >= 208 && marker <= 216)) continue;
			if (i + 1 >= bytes.length) break;
			var seg = (bytes[i] << 8) | bytes[i + 1];
			if (seg < 2) break;
			if ((marker === 192 || marker === 193 || marker === 194) && i + 7 < bytes.length) {
				return { width: (bytes[i + 5] << 8) | bytes[i + 6], height: (bytes[i + 3] << 8) | bytes[i + 4] };
			}
			i += seg;
		}
		return null;
	}

	function readImageSize(file) {
		return file.slice(0, 524288).arrayBuffer().then(function (buf) {
			return imageSizeFromHeader(new Uint8Array(buf));
		}, function () { return null; });
	}

	function decodeWithImage(file) {
		return new Promise(function (resolve, reject) {
			var url = URL.createObjectURL(file);
			var img = new Image();
			img.onload = function () {
				URL.revokeObjectURL(url);
				resolve(img);
			};
			img.onerror = function () {
				URL.revokeObjectURL(url);
				reject();
			};
			img.src = url;
		});
	}

	function decodeFile(file) {
		var bitmap = typeof createImageBitmap === 'function';
		return readImageSize(file).then(function (dim) {
			if (!bitmap) return decodeWithImage(file);
			var opts;
			if (dim && dim.width > 0 && dim.height > 0 && Math.max(dim.width, dim.height) > WORK_EDGE) {
				var scale = WORK_EDGE / Math.max(dim.width, dim.height);
				opts = {
					resizeWidth: Math.max(1, Math.round(dim.width * scale)),
					resizeHeight: Math.max(1, Math.round(dim.height * scale)),
					resizeQuality: 'high'
				};
			}
			var attempt = opts ? createImageBitmap(file, opts) : createImageBitmap(file);
			return attempt.catch(function () { return decodeWithImage(file); });
		});
	}

	function loadFile(file, note) {
		if (!file || file.type.indexOf('image/') !== 0) {
			setStatus('Choose a JPG, PNG, or WEBP image.');
			return;
		}
		if (file.size > FILE_LIMIT) {
			setStatus('This image is over 15 MB. Choose a smaller file.');
			return;
		}
		var token = ++loadToken;
		decodeFile(file).then(function (img) {
			if (token !== loadToken) {
				releaseDecoded(img);
				return;
			}
			setSourceFromImage(img);
			releaseDecoded(img);
			setStatus(note || (subjectMode
				? 'Choose People and animals, or Objects, then blur the background.'
				: faceMode
					? 'Click Blur faces. Then remove a wrong box, or paint any face it missed.'
					: textMode
						? 'Click Auto Blur All Text, or Blur Sensitive Only. Then remove a wrong box, or mark any text it missed.'
						: 'Preview ready. Your image stays in this browser.'));
		}, function () {
			if (token !== loadToken) return;
			setStatus('This browser could not read that file. Try JPG or PNG.');
		});
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
			var settings = {
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
			if (feather) settings.feather = feather.value;
			if (faceMode) settings.faces = JSON.stringify(faceBoxes);
			if (textMode) settings.texts = JSON.stringify(textBoxes);
			if (effectPage) {
				settings.motionAngle = motionAngle;
				settings.radialX = radialX;
				settings.radialY = radialY;
			}
			if (subjectMode) {
				settings.subjectAuto = subjectAuto ? 1 : 0;
				settings.protect = protectMode;
				settings.maskOp = maskOp;
				settings.autoMask = autoHasPixels ? 1 : 0;
			}
			return settings;
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
			if (subjectMode && scopeName === 'whole') scopeName = 'brush';
			if (faceMode) scopeName = 'brush';
			if (textMode && scopeName !== 'brush' && scopeName !== 'marquee') scopeName = 'marquee';
			if (effectPage && settings.motionAngle != null) motionAngle = Number(settings.motionAngle);
			if (effectPage && settings.radialX != null) radialX = Number(settings.radialX);
			if (effectPage && settings.radialY != null) radialY = Number(settings.radialY);
			brush.value = settings.brush;
			if (feather && settings.feather != null) feather.value = settings.feather;
			if (subjectMode && settings.subjectAuto != null) subjectAuto = String(settings.subjectAuto) === '1';
			if (subjectMode && (settings.protect === 'life' || settings.protect === 'things')) protectMode = settings.protect;
			if (subjectMode && (settings.maskOp === 'keep' || settings.maskOp === 'erase')) maskOp = settings.maskOp;
			if (subjectMode) {
				if (String(settings.autoMask) === '1') {
					if (protectMode === 'things' && thingCache) applyThingMask();
					else if (protectMode !== 'things' && categoryCache) rasterizeCategory();
					else clearAutoShape();
				} else clearAutoShape();
			}
			if (faceMode) {
				faceBoxes = [];
				if (settings.faces) {
					try { faceBoxes = JSON.parse(settings.faces) || []; } catch (err) { faceBoxes = []; }
				}
				placeFaceBoxes();
			}
			if (textMode) {
				textBoxes = [];
				if (settings.texts) {
					try { textBoxes = JSON.parse(settings.texts) || []; } catch (err) { textBoxes = []; }
				}
				placeTextBoxes();
			}
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
		ctx.strokeStyle = stroke.op === 'erase' ? '#dc2626' : '#2563eb';
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

	function drawStrokeList(ctx, list, eraseOnly) {
		ctx.save();
		ctx.setTransform(1, 0, 0, 1, 0, 0);
		ctx.globalCompositeOperation = 'source-over';
		list.forEach(function (stroke) {
			var erase = stroke.op === 'erase';
			if (eraseOnly ? !erase : erase) return;
			var kind = stroke.kind || 'brush';
			if (kind === 'marquee') drawMarquee(ctx, stroke);
			else if (kind === 'lasso') drawLasso(ctx, stroke);
			else drawStroke(ctx, stroke, '#fff');
		});
		ctx.restore();
	}

	function redrawMask() {
		clearMask();
		var sctx = shape.getContext('2d');
		sctx.clearRect(0, 0, shape.width, shape.height);
		var list = strokes.slice();
		if (strokeDraft && strokeDraft.points.length) list.push(strokeDraft);
		drawStrokeList(sctx, list, false);
		if (faceMode || textMode) {
			sctx.fillStyle = '#fff';
			var coverBoxes = faceMode ? faceBoxes : textBoxes;
			coverBoxes.forEach(function (box) {
				sctx.fillRect(box.x, box.y, box.w, box.h);
			});
		}
		if (subjectMode && eraseShape.width) {
			var ectx = eraseShape.getContext('2d');
			ectx.clearRect(0, 0, eraseShape.width, eraseShape.height);
			drawStrokeList(ectx, list, true);
		}
		var ictx = ink.getContext('2d');
		list.forEach(function (stroke) { traceSelection(ictx, stroke); });
		if (painting && strokeDraft && (strokeDraft.kind || 'brush') === 'brush') {
			drawStroke(ictx, strokeDraft, strokeDraft.op === 'erase' ? 'rgba(220, 38, 38, 0.45)' : 'rgba(37, 99, 235, 0.45)');
		}
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
		clearAutoShape();
		faceBoxes = [];
		placeFaceBoxes();
		textBoxes = [];
		placeTextBoxes();
		redrawMask();
		applyingHistory = false;
		if (effectPage) {
			motionAngle = 0;
			radialX = 0.5;
			radialY = 0.5;
			syncLabels();
			syncEffectUrl();
		}
		layoutStage();
		pushHistory();
		requestRender();
		setStatus(subjectMode
			? 'Image restored. Choose what to keep sharp, then blur the background again.'
			: faceMode
				? 'Image restored. Click Blur faces again, or paint the faces yourself.'
				: textMode
					? 'Image restored. Click Auto Blur All Text again, or mark the writing yourself.'
					: 'Image restored. Paint and adjustments are back to the start.');
	}

	function effectCacheKey() {
		if (mode === 'unblur') {
			return ['unblur', sharpen.value, radius.value, contrast.value, source.width, source.height].join('|');
		}
		return ['blur', effectName, strengths.gaussian, strengths.pixel, strengths.noise, strengths.motion, strengths.radial, strengths.color, motionAngle, radialX, radialY, source.width, source.height].join('|');
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
		var cx = radialX * (w - 1);
		var cy = radialY * (h - 1);
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

	function paintMotionAngle(src, dest, amount, angleDeg) {
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
		var rad = angleDeg * Math.PI / 180;
		var dx = Math.cos(rad);
		var dy = Math.sin(rad);
		var steps = distance < 8 ? Math.max(2, distance) : 8;
		var y, x, i, t, sx, sy, si, di, r, g, b, a;
		for (y = 0; y < h; y++) {
			for (x = 0; x < w; x++) {
				r = 0;
				g = 0;
				b = 0;
				a = 0;
				for (i = 0; i < steps; i++) {
					t = (i / (steps - 1) - 0.5) * distance;
					sx = clampInt(Math.round(x + dx * t), w - 1);
					sy = clampInt(Math.round(y + dy * t), h - 1);
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

	function paintEffect(src, dest, scale) {
		var amount = Number(strengths[effectName] || 0) * (scale || 1);
		sizeTo(dest, src.width, src.height);
		if (effectName === 'bar' || effectName === 'gray') {
			var barCtx = dest.getContext('2d');
			barCtx.fillStyle = effectName === 'gray' ? '#4b5563' : '#000';
			barCtx.fillRect(0, 0, dest.width, dest.height);
		} else if (effectName === 'pixel') paintPixel(src, dest, amount);
		else if (effectName === 'noise') paintNoise(src, dest, amount);
		else if (effectName === 'motion') {
			if (effectPage && motionAngle % 180 !== 0) paintMotionAngle(src, dest, amount, motionAngle);
			else paintMotion(src, dest, amount);
		}
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

	function shapeIsEmpty() {
		if (faceMode && faceBoxes.length) return false;
		if (textMode && textBoxes.length) return false;
		if (strokeDraft && selectionUseful(strokeDraft)) return false;
		for (var i = 0; i < strokes.length; i++) {
			if (selectionUseful(strokes[i])) return false;
		}
		return true;
	}

	function softenMask(amount, protect) {
		var w = mask.width;
		var h = mask.height;
		var pad = amount * 2;
		sizeTo(featherPad, w + pad * 2, h + pad * 2);
		var pctx = featherPad.getContext('2d');
		pctx.setTransform(1, 0, 0, 1, 0, 0);
		pctx.clearRect(0, 0, featherPad.width, featherPad.height);
		pctx.drawImage(mask, pad, pad);
		if (protect) {
			pctx.fillStyle = '#fff';
			pctx.fillRect(0, 0, featherPad.width, pad);
			pctx.fillRect(0, pad + h, featherPad.width, pad);
			pctx.fillRect(0, pad, pad, h);
			pctx.fillRect(pad + w, pad, pad, h);
		}
		sizeTo(featherBlur, featherPad.width, featherPad.height);
		var bctx = featherBlur.getContext('2d');
		bctx.setTransform(1, 0, 0, 1, 0, 0);
		bctx.clearRect(0, 0, featherBlur.width, featherBlur.height);
		bctx.filter = 'blur(' + Math.max(0.5, amount * 0.35) + 'px)';
		bctx.drawImage(featherPad, 0, 0);
		bctx.filter = 'none';
		var mctx = mask.getContext('2d');
		mctx.setTransform(1, 0, 0, 1, 0, 0);
		mctx.clearRect(0, 0, w, h);
		mctx.drawImage(featherBlur, pad, pad, w, h, 0, 0, w, h);
	}

	function listHas(op) {
		var list = strokes.slice();
		if (strokeDraft && selectionUseful(strokeDraft)) list.push(strokeDraft);
		for (var i = 0; i < list.length; i++) {
			if (!selectionUseful(list[i])) continue;
			var erase = list[i].op === 'erase';
			if (op === 'erase' ? erase : !erase) return true;
		}
		return false;
	}

	function applyCoverage() {
		var w = shape.width;
		var h = shape.height;
		var mctx = mask.getContext('2d');
		mctx.setTransform(1, 0, 0, 1, 0, 0);
		mctx.globalCompositeOperation = 'source-over';
		mctx.clearRect(0, 0, w, h);
		if (!w || !h) return;
		if (!subjectMode) {
			if (shapeIsEmpty()) return;
			mctx.drawImage(shape, 0, 0);
			var plain = feather ? Math.round(Number(feather.value)) : 0;
			if (plain > 0) softenMask(plain, false);
			return;
		}
		var protect = subjectAuto && scopeName !== 'whole';
		var hasKeep = listHas('keep');
		var hasErase = listHas('erase');
		var hasAuto = autoHasPixels;
		if (!hasKeep && !hasAuto) return;
		if (protect) {
			mctx.fillStyle = '#fff';
			mctx.fillRect(0, 0, w, h);
			mctx.globalCompositeOperation = 'destination-out';
			if (hasAuto) mctx.drawImage(autoShape, 0, 0);
			if (hasKeep) mctx.drawImage(shape, 0, 0);
			mctx.globalCompositeOperation = 'source-over';
			if (hasErase) mctx.drawImage(eraseShape, 0, 0);
		} else {
			if (hasAuto) mctx.drawImage(autoShape, 0, 0);
			if (hasKeep) mctx.drawImage(shape, 0, 0);
			if (hasErase) {
				mctx.globalCompositeOperation = 'destination-out';
				mctx.drawImage(eraseShape, 0, 0);
				mctx.globalCompositeOperation = 'source-over';
			}
		}
		var amount = feather ? Math.round(Number(feather.value)) : 0;
		if (amount > 0) softenMask(amount, protect);
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
			applyCoverage();
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
		ctx.setTransform(1, 0, 0, 1, 0, 0);
		ctx.globalCompositeOperation = 'source-over';
		ctx.clearRect(0, 0, view.width, view.height);
		ctx.drawImage(showingOriginal ? source : result, 0, 0);
		if (!subjectMode || !maskShown || showingOriginal || !mask.width) return;
		var tctx = maskTint.getContext('2d');
		tctx.setTransform(1, 0, 0, 1, 0, 0);
		tctx.globalCompositeOperation = 'source-over';
		tctx.clearRect(0, 0, maskTint.width, maskTint.height);
		tctx.fillStyle = 'rgba(220, 38, 38, 0.38)';
		tctx.fillRect(0, 0, maskTint.width, maskTint.height);
		tctx.globalCompositeOperation = 'destination-in';
		tctx.drawImage(mask, 0, 0);
		tctx.globalCompositeOperation = 'source-over';
		ctx.drawImage(maskTint, 0, 0);
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
		var scale = Math.min(1, WORK_EDGE / Math.max(img.width, img.height));
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
		editor.classList.remove('is-editing');
		strokes = [];
		strokeDraft = null;
		faceBoxes = [];
		placeFaceBoxes();
		textBoxes = [];
		placeTextBoxes();
		history = [];
		historyAt = -1;
		showingOriginal = false;
		autoToken++;
		autoBusy = false;
		faceBusy = false;
		textBusy = false;
		categoryCache = null;
		thingCache = null;
		clearAutoShape();
		setAutoProgress(false, 0, '');
		clearMask();
		stage.hidden = true;
		zoomBar.hidden = true;
		historyBar.hidden = true;
		replaceBtn.hidden = true;
		downloadBtn.disabled = true;
		originalBtn.disabled = true;
		syncAutoButton();
		syncFaceButton();
		syncTextButtons();
		syncRefine();
		placeCrop();
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
		var oversized = 0;
		var accepted = [];
		files.forEach(function (file) {
			if (file.size > FILE_LIMIT) oversized++;
			else accepted.push(file);
		});
		files = accepted;
		if (!files.length) {
			setStatus(oversized === 1
				? 'This image is over 15 MB. Choose a smaller file.'
				: 'Each image must be 15 MB or smaller.');
			return;
		}
		if (jobName !== 'batch') {
			loadFile(files[0], files.length > 1 ? 'Loaded the first image. Switch to Batch to blur every file.' : '');
			return;
		}
		var appending = batchAppend || batchItems.length > 0;
		batchAppend = false;
		var limit = batchLimit();
		var room = limit - (appending ? batchItems.length : 0);
		if (room <= 0) {
			setStatus('This batch already has ' + limit + ' images.');
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
			decodeFile(file).then(function (img) {
				if (token !== loadToken) {
					releaseDecoded(img);
					return;
				}
				var sourceCanvas = scaledSource(img);
				releaseDecoded(img);
				var preview = document.createElement('canvas');
				slots[index] = { name: file.name, source: sourceCanvas, preview: preview };
				left--;
				if (left === 0) finishBatch(slots, skipped, appending, oversized, limit);
			}, function () {
				if (token !== loadToken) return;
				left--;
				if (left === 0) finishBatch(slots, skipped, appending, oversized, limit);
			});
		});
	}

	function finishBatch(slots, skipped, appending, oversized, limit) {
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
		var notes = [];
		if (skipped) notes.push('Stopped at ' + limit + ' images. ' + skipped + (skipped === 1 ? ' more was left out.' : ' more were left out.'));
		if (oversized) notes.push(oversized === 1 ? '1 file was over 15 MB.' : oversized + ' files were over 15 MB.');
		if (notes.length) setStatus(notes.join(' '));
	}

	function chooseJob(name) {
		if (!batchEnabled || jobName === name) return;
		loadToken++;
		jobName = name;
		if (name === 'single') {
			var preset = presets[presetName] || presets.soft;
			scopeName = preset.scope === 'brush' || preset.scope === 'marquee' || preset.scope === 'lasso' ? preset.scope : 'whole';
		}
		clearSingleWork();
		clearBatch();
		dropzone.hidden = false;
		batchBox.hidden = true;
		syncJob();
		setStatus(name === 'batch'
			? 'Batch blurs up to ' + batchLimit() + ' whole images with one setting, then downloads a zip.'
			: presetName === 'soft'
				? 'Single image. Brush is ready. Raise Strength, then paint the part that should be harder to read.'
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

	[intensity, brush, sharpen, radius, contrast, feather, motionAngleInput].forEach(function (input) {
		if (!input) return;
		input.addEventListener('input', function () {
			if (input === intensity) strengths[effectName] = Number(intensity.value);
			if (input === motionAngleInput) motionAngle = Number(motionAngleInput.value);
			syncLabels();
			requestRender();
		});
		input.addEventListener('change', commitSettings);
	});

	function chooseEffect(name) {
		if (effectName === name) return;
		effectName = name;
		if (effectPage && effectName === 'motion' && strengths.motion < 1) strengths.motion = 24;
		if (effectPage && effectName === 'radial' && strengths.radial < 1) strengths.radial = 18;
		syncLabels();
		requestRender();
		commitSettings();
		syncEffectUrl();
	}

	function syncEffectControls() {
		if (!effectPage) return;
		if (motionGroup) motionGroup.hidden = effectName !== 'motion';
		if (strengthGroup) strengthGroup.hidden = false;
		if (radialHint) radialHint.hidden = effectName !== 'radial';
		placeFocus();
	}

	function placeFocus() {
		if (!focusLayer || !focusPoint) return;
		var show = effectPage && ready && effectName === 'radial' && jobName !== 'batch';
		focusLayer.hidden = !show;
		if (!show) return;
		focusPoint.style.left = (radialX * 100) + '%';
		focusPoint.style.top = (radialY * 100) + '%';
	}

	function moveFocus(event) {
		var rect = stageCanvas.getBoundingClientRect();
		if (!rect.width || !rect.height) return;
		var x = (event.clientX - rect.left) / rect.width;
		var y = (event.clientY - rect.top) / rect.height;
		if (x < 0) x = 0;
		if (x > 1) x = 1;
		if (y < 0) y = 0;
		if (y > 1) y = 1;
		radialX = x;
		radialY = y;
		placeFocus();
		requestRender();
	}

	function syncEffectUrl() {
		if (!effectPage || !window.history || !window.history.replaceState) return;
		var url = new URL(window.location.href);
		if (url.searchParams.get('type') === effectName) return;
		url.searchParams.set('type', effectName);
		window.history.replaceState(null, '', url.pathname + url.search + url.hash);
	}

	function effectFromUrl() {
		if (!effectPage) return;
		var type = '';
		try { type = new URLSearchParams(window.location.search).get('type') || ''; } catch (err) { return; }
		var map = { gaussian: 'gaussian', pixel: 'pixel', pixelate: 'pixel', noise: 'noise', motion: 'motion', radial: 'radial', color: 'color' };
		type = map[type.toLowerCase()];
		if (!type) return;
		effectName = type;
		if (effectName === 'motion' && strengths.motion < 1) strengths.motion = 24;
		if (effectName === 'radial' && strengths.radial < 1) strengths.radial = 18;
		if (effectName === 'noise' && strengths.noise < 1) strengths.noise = 12;
		if (effectName === 'color' && strengths.color < 1) strengths.color = 12;
		if (effectName === 'pixel' && strengths.pixel <= 1) strengths.pixel = 12;
	}
	function chooseScope(name) {
		if (jobName === 'batch' || scopeName === name) return;
		scopeName = name;
		syncLabels();
		requestRender();
		commitSettings();
		if (subjectMode && name !== 'whole') {
			setStatus(refineStatus());
			return;
		}
		if (textMode) {
			if (name === 'marquee') setStatus('Drag a rectangle around any writing the finder missed.');
			else if (name === 'brush') setStatus('Paint any writing the finder missed.');
			return;
		}
		if (name === 'marquee') setStatus('Drag a rectangle. The blur stays inside it.');
		else if (name === 'lasso') setStatus('Draw around an area and release. The blur stays inside that shape.');
		else if (name === 'brush') setStatus('Paint where the blur should appear.');
	}
	function syncProtectChoices() {
		setChoice(protectLifeBtn, protectMode === 'life');
		setChoice(protectThingsBtn, protectMode === 'things');
	}

	function syncRefine() {
		setChoice(refineKeepBtn, maskOp === 'keep');
		setChoice(refineEraseBtn, maskOp === 'erase');
		if (!maskToggle) return;
		maskToggle.hidden = !(subjectMode && ready);
		maskToggle.classList.toggle('is-on', maskShown);
		maskToggle.setAttribute('aria-pressed', maskShown ? 'true' : 'false');
	}

	function refineStatus() {
		if (scopeName === 'marquee') return maskOp === 'erase' ? 'Drag a rectangle to blur that area.' : 'Drag a rectangle around anything that should stay sharp.';
		if (scopeName === 'lasso') return maskOp === 'erase' ? 'Draw around an area to blur it.' : 'Draw around anything that should stay sharp.';
		return maskOp === 'erase' ? 'Erase where the background should blur.' : 'Paint anything that should stay sharp.';
	}

	function chooseRefine(op) {
		maskOp = op;
		syncLabels();
		requestRender();
		if (ready) commitSettings();
		setStatus(refineStatus());
	}

	function syncAutoButton() {
		if (!blurBgBtn) return;
		blurBgBtn.disabled = !ready || autoBusy;
	}

	function setAutoProgress(visible, ratio, label) {
		if (!autoProgress) return;
		autoProgress.hidden = !visible;
		var pct = Math.round(Math.max(0, Math.min(1, ratio || 0)) * 100);
		if (autoProgressBar) autoProgressBar.style.width = pct + '%';
		var track = autoProgress.querySelector('.auto-progress-track');
		if (track) track.setAttribute('aria-valuenow', String(visible ? pct : 0));
		if (label && autoProgressLabel) autoProgressLabel.textContent = label;
	}

	function clearAutoShape() {
		autoHasPixels = false;
		if (!autoShape.width) return;
		autoShape.getContext('2d').clearRect(0, 0, autoShape.width, autoShape.height);
	}

	function reportAuto(ratio, label) {
		if (!autoBusy && !faceBusy && !textBusy) return;
		setAutoProgress(true, ratio, label);
	}

	function waitFrame() {
		return new Promise(function (resolve) {
			requestAnimationFrame(function () { setTimeout(resolve, 40); });
		});
	}

	function trackFetch(url, onRatio) {
		return fetch(url).then(function (res) {
			if (!res.ok || !res.body || !res.body.getReader) {
				if (!res.ok) throw new Error('download failed');
				return res.arrayBuffer().then(function (buf) {
					onRatio(1);
					return buf;
				});
			}
			var total = Number(res.headers.get('Content-Length')) || 0;
			var reader = res.body.getReader();
			var parts = [];
			var got = 0;
			function read() {
				return reader.read().then(function (step) {
					if (step.done) {
						var out = new Uint8Array(got);
						var at = 0;
						parts.forEach(function (part) {
							out.set(part, at);
							at += part.length;
						});
						onRatio(1);
						return out.buffer;
					}
					parts.push(step.value);
					got += step.value.length;
					onRatio(total > 0 ? Math.min(0.99, got / total) : 0.5);
					return read();
				});
			}
			return read();
		});
	}

	function rasterizeCategory() {
		if (!categoryCache || !source.width) {
			clearAutoShape();
			return false;
		}
		var keep = LIFE_CLASSES;
		var mw = categoryCache.width;
		var mh = categoryCache.height;
		var src = categoryCache.data;
		var img = new ImageData(mw, mh);
		var px = img.data;
		var count = 0;
		var i;
		for (i = 0; i < mw * mh && i < src.length; i++) {
			if (!keep[src[i]]) continue;
			var o = i * 4;
			px[o] = 255;
			px[o + 1] = 255;
			px[o + 2] = 255;
			px[o + 3] = 255;
			count++;
		}
		var scratch = document.createElement('canvas');
		scratch.width = mw;
		scratch.height = mh;
		scratch.getContext('2d').putImageData(img, 0, 0);
		sizeTo(autoShape, source.width, source.height);
		var actx = autoShape.getContext('2d');
		actx.setTransform(1, 0, 0, 1, 0, 0);
		actx.imageSmoothingEnabled = true;
		actx.clearRect(0, 0, autoShape.width, autoShape.height);
		actx.drawImage(scratch, 0, 0, autoShape.width, autoShape.height);
		autoHasPixels = count > 0;
		return autoHasPixels;
	}

	function applyThingMask() {
		var size = 320;
		if (!thingCache || thingCache.length < size * size || !source.width) {
			clearAutoShape();
			return false;
		}
		var img = new ImageData(size, size);
		var px = img.data;
		var count = 0;
		var i;
		for (i = 0; i < size * size; i++) {
			var alpha = thingCache[i];
			if (alpha < 24) continue;
			var o = i * 4;
			px[o] = 255;
			px[o + 1] = 255;
			px[o + 2] = 255;
			px[o + 3] = alpha;
			count++;
		}
		var ratio = count / (size * size);
		if (ratio < 0.015 || ratio > 0.97) {
			clearAutoShape();
			return false;
		}
		var scratch = document.createElement('canvas');
		scratch.width = size;
		scratch.height = size;
		scratch.getContext('2d').putImageData(img, 0, 0);
		sizeTo(autoShape, source.width, source.height);
		var actx = autoShape.getContext('2d');
		actx.setTransform(1, 0, 0, 1, 0, 0);
		actx.imageSmoothingEnabled = true;
		actx.clearRect(0, 0, autoShape.width, autoShape.height);
		actx.drawImage(scratch, 0, 0, autoShape.width, autoShape.height);
		autoHasPixels = true;
		return true;
	}

	function thingInput(canvas) {
		var size = 320;
		var scratch = document.createElement('canvas');
		scratch.width = size;
		scratch.height = size;
		var ctx = scratch.getContext('2d');
		ctx.drawImage(canvas, 0, 0, size, size);
		var data = ctx.getImageData(0, 0, size, size).data;
		var peak = 1;
		var i;
		for (i = 0; i < data.length; i += 4) {
			if (data[i] > peak) peak = data[i];
			if (data[i + 1] > peak) peak = data[i + 1];
			if (data[i + 2] > peak) peak = data[i + 2];
		}
		var mean = [0.485, 0.456, 0.406];
		var std = [0.229, 0.224, 0.225];
		var plane = size * size;
		var input = new Float32Array(3 * plane);
		var y;
		var x;
		var c;
		for (y = 0; y < size; y++) {
			for (x = 0; x < size; x++) {
				var p = (y * size + x) * 4;
				var at = y * size + x;
				for (c = 0; c < 3; c++) {
					input[c * plane + at] = (data[p + c] / peak - mean[c]) / std[c];
				}
			}
		}
		return input;
	}

	function readCategory(maskResult) {
		var category = maskResult && maskResult.categoryMask;
		if (!category) return null;
		var bytes = category.getAsUint8Array();
		var width = category.width;
		var height = category.height;
		var needed = width * height;
		if (bytes.length < needed) {
			if (maskResult.close) maskResult.close();
			return null;
		}
		var copy = new Uint8Array(needed);
		copy.set(bytes.subarray(0, needed));
		if (maskResult.close) maskResult.close();
		return { data: copy, width: width, height: height };
	}

	function loadSegmenter() {
		var visionUrl = 'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@1.0.1/+esm';
		var wasmBase = 'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@1.0.1/wasm';
		var modelUrl = 'https://storage.googleapis.com/mediapipe-models/image_segmenter/deeplab_v3/float32/1/deeplab_v3.tflite';
		reportAuto(0.02, 'Downloading the runtime…');
		return trackFetch(visionUrl, function (ratio) {
			reportAuto(0.02 + ratio * 0.08, 'Downloading the runtime…');
		}).then(function () {
			return import(visionUrl);
		}).then(function (vision) {
			return vision.FilesetResolver.isSimdSupported().then(function (simd) {
				var stem = simd ? 'vision_wasm_internal' : 'vision_wasm_nosimd_internal';
				return trackFetch(wasmBase + '/' + stem + '.js', function (ratio) {
					reportAuto(0.10 + ratio * 0.06, 'Downloading the runtime…');
				}).then(function () {
					return trackFetch(wasmBase + '/' + stem + '.wasm', function (ratio) {
						reportAuto(0.16 + ratio * 0.46, 'Downloading the runtime…');
					});
				}).then(function () {
					reportAuto(0.62, 'Downloading the model…');
					return trackFetch(modelUrl, function (ratio) {
						reportAuto(0.62 + ratio * 0.26, 'Downloading the model…');
					}).then(function (modelBuffer) {
						return { vision: vision, model: new Uint8Array(modelBuffer) };
					});
				});
			});
		}).then(function (pack) {
			reportAuto(0.90, 'Finding the subject…');
			return pack.vision.FilesetResolver.forVisionTasks(wasmBase).then(function (fileset) {
				function create(delegate) {
					return pack.vision.ImageSegmenter.createFromOptions(fileset, {
						baseOptions: { modelAssetBuffer: pack.model, delegate: delegate },
						runningMode: 'IMAGE',
						outputCategoryMask: true,
						outputConfidenceMasks: false
					});
				}
				return create('GPU').catch(function () { return create('CPU'); });
			});
		});
	}

	function ensureSegmenter() {
		if (segmenter) return Promise.resolve(segmenter);
		if (!segmenterPromise) {
			segmenterPromise = loadSegmenter().then(function (created) {
				segmenter = created;
				return created;
			}, function (err) {
				segmenterPromise = null;
				throw err;
			});
		}
		return segmenterPromise;
	}

	function loadThingSession() {
		var modelUrl = editor.getAttribute('data-object-model');
		var ortBase = 'https://cdn.jsdelivr.net/npm/onnxruntime-web@1.21.0/dist/';
		if (!modelUrl) return Promise.reject(new Error('no model'));
		reportAuto(0.02, '');
		return trackFetch(ortBase + 'ort.wasm.min.mjs', function (ratio) {
			reportAuto(0.02 + ratio * 0.06, '');
		}).then(function () {
			return import(ortBase + 'ort.wasm.min.mjs');
		}).then(function (ortMod) {
			ortMod.env.wasm.wasmPaths = ortBase;
			ortMod.env.wasm.numThreads = 1;
			thingTensor = ortMod.Tensor;
			return trackFetch(ortBase + 'ort-wasm-simd-threaded.mjs', function (ratio) {
				reportAuto(0.08 + ratio * 0.04, '');
			}).then(function () {
				return trackFetch(ortBase + 'ort-wasm-simd-threaded.wasm', function (ratio) {
					reportAuto(0.12 + ratio * 0.50, '');
				});
			}).then(function () {
				reportAuto(0.64, '');
				return trackFetch(modelUrl, function (ratio) {
					reportAuto(0.64 + ratio * 0.26, '');
				});
			}).then(function (modelBuffer) {
				reportAuto(0.92, '');
				return ortMod.InferenceSession.create(new Uint8Array(modelBuffer), {
					executionProviders: ['wasm']
				});
			});
		});
	}

	function ensureThingSession() {
		if (thingSession) return Promise.resolve(thingSession);
		if (!thingSessionPromise) {
			thingSessionPromise = loadThingSession().then(function (created) {
				thingSession = created;
				return created;
			}, function (err) {
				thingSessionPromise = null;
				throw err;
			});
		}
		return thingSessionPromise;
	}

	function segmentSource(token) {
		if (categoryCache) {
			reportAuto(0.97, 'Blurring the background…');
			return Promise.resolve(rasterizeCategory());
		}
		reportAuto(0.92, 'Finding the subject…');
		return waitFrame().then(function () {
			if (token !== autoToken || !segmenter) return null;
			var result = segmenter.segment(source);
			if (token !== autoToken) {
				if (result && result.categoryMask) result.categoryMask.close();
				if (result && result.close) result.close();
				return null;
			}
			categoryCache = readCategory(result);
			if (!categoryCache) throw new Error('no mask');
			reportAuto(0.97, 'Blurring the background…');
			return rasterizeCategory();
		});
	}

	function segmentThings(token) {
		if (thingCache) {
			reportAuto(0.97, '');
			return Promise.resolve(applyThingMask());
		}
		reportAuto(0.93, '');
		return waitFrame().then(function () {
			if (token !== autoToken || !thingSession || !thingTensor) return null;
			var feeds = {};
			feeds[thingSession.inputNames[0]] = new thingTensor('float32', thingInput(source), [1, 3, 320, 320]);
			return thingSession.run(feeds).then(function (out) {
				if (token !== autoToken) return null;
				var pred = out[thingSession.outputNames[0]].data;
				var min = pred[0];
				var max = pred[0];
				var i;
				for (i = 1; i < pred.length; i++) {
					if (pred[i] < min) min = pred[i];
					if (pred[i] > max) max = pred[i];
				}
				if (max - min < 1e-4) return false;
				var bytes = new Uint8Array(pred.length);
				for (i = 0; i < pred.length; i++) {
					var n = (pred[i] - min) / (max - min);
					if (n < 0) n = 0;
					if (n > 1) n = 1;
					bytes[i] = Math.round(n * 255);
				}
				thingCache = bytes;
				reportAuto(0.97, '');
				return applyThingMask();
			});
		});
	}

	function chooseProtect(mode) {
		if (!subjectMode || autoBusy || protectMode === mode) return;
		protectMode = mode;
		syncProtectChoices();
		var cached = mode === 'things' ? thingCache : categoryCache;
		if (cached) {
			var found = mode === 'things' ? applyThingMask() : rasterizeCategory();
			if (found) {
				subjectAuto = true;
				setStatus(mode === 'things'
					? 'Kept the subject sharp. Paint any part it missed.'
					: 'Kept that choice sharp. Paint any missed part. Hair and fur often need a touch-up.');
			} else {
				setStatus(mode === 'things'
					? 'No clear subject was found. Try People and animals, or paint the subject.'
					: 'Nothing in that choice was found. Try the other choice, or paint the subject.');
			}
			requestRender();
		} else {
			clearAutoShape();
			requestRender();
		}
		syncLabels();
		if (ready) commitSettings();
	}

	function blurBackground() {
		if (!subjectMode || !ready || autoBusy) return;
		var token = ++autoToken;
		var objects = protectMode === 'things';
		var cached = objects ? thingCache : categoryCache;
		autoBusy = true;
		syncAutoButton();
		setAutoProgress(true, cached ? 0.9 : 0.02, '');
		var loader = objects ? ensureThingSession : ensureSegmenter;
		var runner = objects ? segmentThings : segmentSource;
		loader().then(function () {
			if (token !== autoToken) return null;
			return runner(token);
		}).then(function (found) {
			if (token !== autoToken || found == null) return;
			if (!found) {
				clearAutoShape();
				requestRender();
				setStatus(objects
					? 'No clear subject was found. Try People and animals, or paint the subject.'
					: 'Nothing in that choice was found. Try the other choice, or paint the subject.');
				return;
			}
			subjectAuto = true;
			syncLabels();
			requestRender();
			commitSettings();
			setStatus(objects
				? 'Background softened. Paint any part of the subject it missed.'
				: 'Background softened. Paint any missed part. Hair and fur often need a touch-up.');
		}).catch(function () {
			if (token !== autoToken) return;
			setStatus('The finder could not run in this browser. Paint the subject instead.');
		}).then(function () {
			if (token !== autoToken) return;
			autoBusy = false;
			setAutoProgress(false, 0, '');
			syncAutoButton();
		});
	}

	if (subjectAutoBtn) subjectAutoBtn.addEventListener('click', function () {
		subjectAuto = !subjectAuto;
		syncLabels();
		requestRender();
		commitSettings();
		if (subjectMode) setStatus(subjectAuto ? 'Kept area stays sharp. The rest blurs.' : 'Kept area blurs. The rest stays sharp.');
	});
	if (refineKeepBtn) refineKeepBtn.addEventListener('click', function () { chooseRefine('keep'); });
	if (refineEraseBtn) refineEraseBtn.addEventListener('click', function () { chooseRefine('erase'); });
	if (maskToggle) maskToggle.addEventListener('click', function (event) {
		event.stopPropagation();
		maskShown = !maskShown;
		syncRefine();
		requestRender();
	});
	if (protectLifeBtn) protectLifeBtn.addEventListener('click', function () { chooseProtect('life'); });
	if (protectThingsBtn) protectThingsBtn.addEventListener('click', function () { chooseProtect('things'); });
	function syncFaceButton() {
		if (!blurFacesBtn) return;
		blurFacesBtn.disabled = !ready || faceBusy;
	}

	function placeFaceBoxes() {
		if (!faceLayer) return;
		faceLayer.innerHTML = '';
		faceLayer.hidden = !faceBoxes.length || !source.width;
		if (!source.width || !source.height) return;
		faceBoxes.forEach(function (box, index) {
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'face-box';
			btn.setAttribute('aria-label', 'Remove this face');
			btn.style.left = (box.x / source.width * 100) + '%';
			btn.style.top = (box.y / source.height * 100) + '%';
			btn.style.width = (box.w / source.width * 100) + '%';
			btn.style.height = (box.h / source.height * 100) + '%';
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				faceBoxes.splice(index, 1);
				placeFaceBoxes();
				redrawMask();
				requestRender();
				commitSettings();
				setStatus('That box is removed. Paint any face that should still be covered.');
			});
			faceLayer.appendChild(btn);
		});
	}

	function clampFaceBox(x, y, w, h, width, height) {
		if (x < 0) { w += x; x = 0; }
		if (y < 0) { h += y; y = 0; }
		if (x + w > width) w = width - x;
		if (y + h > height) h = height - y;
		if (w < 8 || h < 8) return null;
		return { x: x, y: y, w: w, h: h };
	}

	function mapDetectorMeasure(value, span) {
		if (value >= 0 && value <= 1.2) return value * span;
		return value;
	}

	function mapDetectorRect(raw, cropW, cropH, ox, oy) {
		if (!raw) return null;
		var x = mapDetectorMeasure(raw.originX, cropW) + ox;
		var y = mapDetectorMeasure(raw.originY, cropH) + oy;
		var w = mapDetectorMeasure(raw.width, cropW);
		var h = mapDetectorMeasure(raw.height, cropH);
		if (w < 2 || h < 2) return null;
		return { x: x, y: y, w: w, h: h };
	}

	function mapDetectorPoints(points, cropW, cropH, ox, oy) {
		var pts = [];
		(points || []).forEach(function (point) {
			if (!point || point.x == null || point.y == null) return;
			pts.push({
				x: mapDetectorMeasure(point.x, cropW) + ox,
				y: mapDetectorMeasure(point.y, cropH) + oy
			});
		});
		return pts;
	}

	function faceCover(points, fallback, width, height) {
		if (!fallback) return null;
		var cx = fallback.x + fallback.w / 2;
		var cy = fallback.y + fallback.h / 2;
		if (points.length >= 6) {
			cx = (points[0].x + points[1].x) / 2;
			cy = (points[0].y + points[1].y) / 2;
		}
		var side = Math.max(fallback.w, fallback.h);
		var w = side;
		var h = side * 1.46;
		return clampFaceBox(cx - w / 2, cy - h * 0.38, w, h, width, height);
	}

	function faceIou(a, b) {
		var x1 = Math.max(a.x, b.x);
		var y1 = Math.max(a.y, b.y);
		var x2 = Math.min(a.x + a.w, b.x + b.w);
		var y2 = Math.min(a.y + a.h, b.y + b.h);
		var iw = x2 - x1;
		var ih = y2 - y1;
		if (iw <= 0 || ih <= 0) return 0;
		var inter = iw * ih;
		return inter / (a.w * a.h + b.w * b.h - inter);
	}

	function faceSame(a, b) {
		if (faceIou(a, b) > 0.32) return true;
		var ax = a.x + a.w / 2;
		var ay = a.y + a.h / 2;
		var bx = b.x + b.w / 2;
		var by = b.y + b.h / 2;
		var dist = Math.sqrt((ax - bx) * (ax - bx) + (ay - by) * (ay - by));
		var scale = (Math.max(a.w, a.h) + Math.max(b.w, b.h)) / 2;
		return dist < scale * 0.42;
	}

	function mergeFaceHits(items) {
		items.sort(function (a, b) { return b.score - a.score; });
		var kept = [];
		items.forEach(function (item) {
			var same = false;
			for (var i = 0; i < kept.length; i++) {
				if (faceSame(kept[i], item)) {
					same = true;
					break;
				}
			}
			if (!same) kept.push(item);
		});
		return kept;
	}

	function collectFaceHits(detector, target, ox, oy, imgW, imgH) {
		var found = detector.detect(target);
		var list = found && found.detections ? found.detections : [];
		var hits = [];
		list.forEach(function (hit) {
			var raw = mapDetectorRect(hit.boundingBox, target.width, target.height, ox, oy);
			var pts = mapDetectorPoints(hit.keypoints, target.width, target.height, ox, oy);
			var box = faceCover(pts, raw, imgW, imgH);
			if (!box) return;
			var score = 0.5;
			if (hit.categories && hit.categories.length && hit.categories[0].score != null) score = Number(hit.categories[0].score);
			hits.push({ x: box.x, y: box.y, w: box.w, h: box.h, score: score });
		});
		return hits;
	}

	function scanFaceTiles(canvas) {
		var hits = collectFaceHits(faceDetector, canvas, 0, 0, canvas.width, canvas.height);
		if (faceDetectorNear) hits = hits.concat(collectFaceHits(faceDetectorNear, canvas, 0, 0, canvas.width, canvas.height));
		var tw = Math.max(8, Math.round(canvas.width * 0.56));
		var th = Math.max(8, Math.round(canvas.height * 0.56));
		var xs = [0, Math.max(0, canvas.width - tw)];
		var ys = [0, Math.max(0, canvas.height - th)];
		var crop = document.createElement('canvas');
		crop.width = tw;
		crop.height = th;
		var ctx = crop.getContext('2d');
		var yi, xi, ox, oy;
		for (yi = 0; yi < ys.length; yi++) {
			for (xi = 0; xi < xs.length; xi++) {
				ox = xs[xi];
				oy = ys[yi];
				if (ox === 0 && oy === 0 && tw === canvas.width && th === canvas.height) continue;
				ctx.clearRect(0, 0, tw, th);
				ctx.drawImage(canvas, ox, oy, tw, th, 0, 0, tw, th);
				hits = hits.concat(collectFaceHits(faceDetector, crop, ox, oy, canvas.width, canvas.height));
			}
		}
		return mergeFaceHits(hits);
	}

	function loadFaceDetector() {
		var visionUrl = 'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@1.0.1/+esm';
		var wasmBase = 'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@1.0.1/wasm';
		var modelUrl = 'https://storage.googleapis.com/mediapipe-models/face_detector/blaze_face_full_range/float16/latest/blaze_face_full_range.tflite';
		var nearUrl = 'https://storage.googleapis.com/mediapipe-models/face_detector/blaze_face_short_range/float16/latest/blaze_face_short_range.tflite';
		reportAuto(0.02, '');
		return trackFetch(visionUrl, function (ratio) {
			reportAuto(0.02 + ratio * 0.08, '');
		}).then(function () {
			return import(visionUrl);
		}).then(function (vision) {
			return vision.FilesetResolver.isSimdSupported().then(function (simd) {
				var stem = simd ? 'vision_wasm_internal' : 'vision_wasm_nosimd_internal';
				return trackFetch(wasmBase + '/' + stem + '.js', function (ratio) {
					reportAuto(0.10 + ratio * 0.06, '');
				}).then(function () {
					return trackFetch(wasmBase + '/' + stem + '.wasm', function (ratio) {
						reportAuto(0.16 + ratio * 0.46, '');
					});
				}).then(function () {
					reportAuto(0.62, '');
					return trackFetch(modelUrl, function (ratio) {
						reportAuto(0.62 + ratio * 0.18, '');
					}).then(function (modelBuffer) {
						return trackFetch(nearUrl, function (ratio) {
							reportAuto(0.80 + ratio * 0.08, '');
						}).then(function (nearBuffer) {
							return { vision: vision, model: new Uint8Array(modelBuffer), near: new Uint8Array(nearBuffer) };
						});
					});
				});
			});
		}).then(function (pack) {
			reportAuto(0.90, '');
			return pack.vision.FilesetResolver.forVisionTasks(wasmBase).then(function (fileset) {
				function create(buffer, delegate) {
					return pack.vision.FaceDetector.createFromOptions(fileset, {
						baseOptions: { modelAssetBuffer: buffer, delegate: delegate },
						runningMode: 'IMAGE',
						minDetectionConfidence: FACE_MIN_SCORE,
						minSuppressionThreshold: 0.65
					});
				}
				function open(buffer) {
					return create(buffer, 'GPU').catch(function () { return create(buffer, 'CPU'); });
				}
				return open(pack.model).then(function (full) {
					return open(pack.near).then(function (near) {
						return { full: full, near: near };
					}, function () {
						return { full: full, near: null };
					});
				});
			});
		});
	}

	function ensureFaceDetector() {
		if (faceDetector) return Promise.resolve(faceDetector);
		if (!faceDetectorPromise) {
			faceDetectorPromise = loadFaceDetector().then(function (created) {
				faceDetector = created.full;
				faceDetectorNear = created.near;
				return created.full;
			}, function (err) {
				faceDetectorPromise = null;
				throw err;
			});
		}
		return faceDetectorPromise;
	}

	function blurFaces() {
		if (!faceMode || !ready || faceBusy) return;
		var token = ++autoToken;
		faceBusy = true;
		autoBusy = true;
		syncFaceButton();
		setAutoProgress(true, faceDetector ? 0.9 : 0.02, '');
		ensureFaceDetector().then(function () {
			if (token !== autoToken || !faceDetector) return null;
			reportAuto(0.94, '');
			return waitFrame().then(function () {
				if (token !== autoToken || !faceDetector) return null;
				reportAuto(0.97, '');
				var hits = scanFaceTiles(source);
				return hits.map(function (hit) {
					return { x: hit.x, y: hit.y, w: hit.w, h: hit.h };
				});
			});
		}).then(function (boxes) {
			if (token !== autoToken || !boxes) return;
			faceBoxes = boxes;
			placeFaceBoxes();
			redrawMask();
			requestRender();
			commitSettings();
			setStatus(boxes.length
				? (boxes.length === 1
					? '1 face covered. Click the box to remove it, or paint any face that was missed.'
					: boxes.length + ' faces covered. Click a box to remove it, or paint any face that was missed.')
				: 'No face was found. Paint any face that should be covered.');
		}).catch(function () {
			if (token !== autoToken) return;
			setStatus('The finder could not run in this browser. Paint the faces instead.');
		}).then(function () {
			if (token !== autoToken) return;
			faceBusy = false;
			autoBusy = false;
			setAutoProgress(false, 0, '');
			syncFaceButton();
		});
	}

	function syncTextButtons() {
		var locked = !ready || textBusy;
		if (blurTextAllBtn) blurTextAllBtn.disabled = locked;
		if (blurTextSensitiveBtn) blurTextSensitiveBtn.disabled = locked;
	}

	function syncTextStyle() {
		if (!textMode) return;
		var solid = effectName === 'bar' || effectName === 'gray';
		setChoice(effectButtons.bar, solid);
		setChoice(effectButtons.pixel, effectName === 'pixel');
		setChoice(effectButtons.gaussian, effectName === 'gaussian');
		if (redactTones) redactTones.hidden = !solid;
		setChoice(redactBlackBtn, effectName === 'bar');
		setChoice(redactGrayBtn, effectName === 'gray');
	}

	function placeTextBoxes() {
		if (!textLayer) return;
		textLayer.innerHTML = '';
		textLayer.hidden = !textBoxes.length || !source.width;
		if (!source.width || !source.height) return;
		textBoxes.forEach(function (box, index) {
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'ocr-box';
			btn.setAttribute('aria-label', box.text ? 'Remove ' + box.text : 'Remove this text');
			if (box.text) btn.title = box.text;
			btn.style.left = (box.x / source.width * 100) + '%';
			btn.style.top = (box.y / source.height * 100) + '%';
			btn.style.width = (box.w / source.width * 100) + '%';
			btn.style.height = (box.h / source.height * 100) + '%';
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				textBoxes.splice(index, 1);
				placeTextBoxes();
				redrawMask();
				requestRender();
				commitSettings();
				setStatus('That box is removed. Mark any text that should still be covered.');
			});
			textLayer.appendChild(btn);
		});
	}

	function expandTextBox(box, width, height) {
		var padW = Math.max(3, box.w * 0.12);
		var padH = Math.max(3, box.h * 0.2);
		var x = box.x - padW / 2;
		var y = box.y - padH / 2;
		var w = box.w + padW;
		var h = box.h + padH;
		if (x < 0) { w += x; x = 0; }
		if (y < 0) { h += y; y = 0; }
		if (x + w > width) w = width - x;
		if (y + h > height) h = height - y;
		if (w < 2 || h < 2) return null;
		return { x: x, y: y, w: w, h: h, text: box.text || '' };
	}

	function readWord(word) {
		if (!word) return null;
		var b = word.bbox || word;
		var x0 = b.x0 != null ? b.x0 : b.left;
		var y0 = b.y0 != null ? b.y0 : b.top;
		var x1 = b.x1 != null ? b.x1 : b.right;
		var y1 = b.y1 != null ? b.y1 : b.bottom;
		if (x0 == null || y0 == null || x1 == null || y1 == null) return null;
		return {
			text: String(word.text || ''),
			confidence: Number(word.confidence || 0),
			x0: x0,
			y0: y0,
			x1: x1,
			y1: y1
		};
	}

	function groupWords(data) {
		var lines = [];
		function addLine(line) {
			var words = (line.words || []).map(readWord).filter(Boolean);
			if (words.length) lines.push(words);
		}
		(data && data.blocks ? data.blocks : []).forEach(function (block) {
			(block.paragraphs || []).forEach(function (para) {
				(para.lines || []).forEach(addLine);
			});
		});
		if (lines.length) return lines;
		(data && data.lines ? data.lines : []).forEach(addLine);
		if (lines.length) return lines;
		var flat = (data && data.words ? data.words : []).map(readWord).filter(Boolean);
		flat.sort(function (a, b) { return a.y0 - b.y0 || a.x0 - b.x0; });
		flat.forEach(function (word) {
			var last = lines[lines.length - 1];
			var mid = (word.y0 + word.y1) / 2;
			if (!last || mid > last[0].y1 + 2) lines.push([word]);
			else last.push(word);
		});
		return lines;
	}

	function numericToken(text) {
		return /^[\d\s().+\-xX]+$/.test(String(text || '')) && /\d/.test(text);
	}

	function sensitiveWords(words) {
		var hit = {};
		var parts = [];
		var cursor = 0;
		var i;
		for (i = 0; i < words.length; i++) {
			var text = String(words[i].text || '');
			if (i) cursor += 1;
			parts.push({ i: i, start: cursor, end: cursor + text.length });
			cursor += text.length;
		}
		var line = words.map(function (word) { return String(word.text || ''); }).join(' ');
		var email = /[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}/ig;
		var match;
		while ((match = email.exec(line))) {
			for (i = 0; i < parts.length; i++) {
				if (parts[i].end > match.index && parts[i].start < match.index + match[0].length) hit[parts[i].i] = 1;
			}
		}
		var run = [];
		function flush() {
			if (!run.length) return;
			var joined = run.map(function (word) { return String(word.text || ''); }).join('');
			var extra = joined.replace(/[\d\s().+\-xX]/g, '');
			var digits = joined.replace(/\D/g, '');
			if (!extra && digits.length >= 10 && digits.length <= 19) {
				run.forEach(function (word) { hit[word._i] = 1; });
			}
			run = [];
		}
		words.forEach(function (word, idx) {
			word._i = idx;
			if (numericToken(word.text)) run.push(word);
			else flush();
		});
		flush();
		return words.filter(function (word, idx) { return hit[idx]; });
	}

	function boxesFromOcr(data, width, height, sensitive) {
		var boxes = [];
		groupWords(data).forEach(function (words) {
			var chosen = sensitive ? sensitiveWords(words) : words;
			chosen.forEach(function (word) {
				var text = String(word.text || '').trim();
				if (!text || !/[0-9A-Za-z]/.test(text)) return;
				var floor = sensitive ? 15 : 40;
				if (word.confidence && word.confidence < floor) return;
				var w = word.x1 - word.x0;
				var h = word.y1 - word.y0;
				if (w < 2 || h < 2) return;
				var box = expandTextBox({ x: word.x0, y: word.y0, w: w, h: h, text: text }, width, height);
				if (box) boxes.push(box);
			});
		});
		return boxes;
	}

	function textLogger(message) {
		if (!textBusy) return;
		var status = message && message.status ? String(message.status) : '';
		var ratio = message && message.progress ? Number(message.progress) : 0;
		var p = 0.12;
		if (status.indexOf('core') >= 0) p = 0.12 + ratio * 0.28;
		else if (status.indexOf('initial') >= 0) p = 0.42;
		else if (status.indexOf('lang') >= 0 || status.indexOf('traineddata') >= 0) p = 0.48 + ratio * 0.22;
		else if (status.indexOf('recogniz') >= 0) p = 0.72 + ratio * 0.24;
		reportAuto(p, '');
	}

	function loadTextWorker() {
		var esm = 'https://cdn.jsdelivr.net/npm/tesseract.js@7.0.0/dist/tesseract.esm.min.js';
		reportAuto(0.04, '');
		return import(esm).then(function (mod) {
			reportAuto(0.08, '');
			var api = mod.default || mod;
			return api.createWorker('eng', 1, { logger: textLogger });
		});
	}

	function ensureTextWorker() {
		if (textWorker) return Promise.resolve(textWorker);
		if (!textWorkerPromise) {
			textWorkerPromise = loadTextWorker().then(function (created) {
				textWorker = created;
				return created;
			}, function (err) {
				textWorkerPromise = null;
				throw err;
			});
		}
		return textWorkerPromise;
	}

	function blurText(sensitive) {
		if (!textMode || !ready || textBusy) return;
		var token = ++autoToken;
		textBusy = true;
		syncTextButtons();
		setAutoProgress(true, textWorker ? 0.72 : 0.04, '');
		ensureTextWorker().then(function (worker) {
			if (token !== autoToken || !worker) return null;
			var snap = document.createElement('canvas');
			snap.width = source.width;
			snap.height = source.height;
			snap.getContext('2d').drawImage(source, 0, 0);
			reportAuto(0.74, '');
			return worker.recognize(snap, {}, { text: true, blocks: true }).then(function (ret) {
				if (token !== autoToken) return null;
				return boxesFromOcr(ret && ret.data, snap.width, snap.height, sensitive);
			});
		}).then(function (boxes) {
			if (token !== autoToken || !boxes) return;
			textBoxes = boxes;
			if (sensitive && boxes.length && effectName !== 'bar' && effectName !== 'gray') effectName = 'bar';
			placeTextBoxes();
			syncLabels();
			redrawMask();
			requestRender();
			commitSettings();
			if (!boxes.length) {
				setStatus(sensitive
					? 'No email, phone, or long number was found. Try all text, or mark the writing yourself.'
					: 'No text was found. Drag a box or paint any writing that should be covered.');
				return;
			}
			setStatus(sensitive
				? 'Sensitive text is covered with a solid block. Click a box to remove it, or mark anything missed.'
				: 'Text covered. Click a box to remove it, or mark any writing that was missed.');
		}).catch(function () {
			if (token !== autoToken) return;
			setStatus('The finder could not run in this browser. Drag a box or paint the writing instead.');
		}).then(function () {
			if (token !== autoToken) return;
			textBusy = false;
			setAutoProgress(false, 0, '');
			syncTextButtons();
		});
	}

	if (blurTextAllBtn) blurTextAllBtn.addEventListener('click', function () { blurText(false); });
	if (blurTextSensitiveBtn) blurTextSensitiveBtn.addEventListener('click', function () { blurText(true); });
	if (redactBlackBtn) redactBlackBtn.addEventListener('click', function () { chooseEffect('bar'); });
	if (redactGrayBtn) redactGrayBtn.addEventListener('click', function () { chooseEffect('gray'); });
	if (blurFacesBtn) blurFacesBtn.addEventListener('click', blurFaces);
	if (blurBgBtn) blurBgBtn.addEventListener('click', blurBackground);
	effectNames.forEach(function (name) {
		if (effectButtons[name]) effectButtons[name].addEventListener('click', function () { chooseEffect(name); });
	});
	if (scopeWholeBtn) scopeWholeBtn.addEventListener('click', function () { chooseScope('whole'); });
	if (scopeBrushBtn) scopeBrushBtn.addEventListener('click', function () { chooseScope('brush'); });
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
		var hadDraft = !!strokeDraft;
		if (painting && selectionUseful(strokeDraft)) {
			strokes.push(strokeDraft);
			pushHistory();
		}
		strokeDraft = null;
		painting = false;
		panning = false;
		panStart = null;
		stage.classList.remove('is-panning');
		if (hadDraft) redrawMask();
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
			op: subjectMode && maskOp === 'erase' ? 'erase' : 'keep',
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
	function syncHeaderOffset() {
		var header = document.querySelector('.site-header');
		if (header) document.documentElement.style.setProperty('--header-offset', header.offsetHeight + 'px');
	}
	syncHeaderOffset();
	if (window.ResizeObserver) {
		var header = document.querySelector('.site-header');
		if (header) new ResizeObserver(syncHeaderOffset).observe(header);
	}
	window.addEventListener('resize', function () {
		syncHeaderOffset();
		if (ready) layoutStage();
	});

	function showOriginal(on) {
		showingOriginal = on;
		if (ready) paintView();
	}
	function releaseOriginal() {
		showOriginal(false);
	}
	originalBtn.addEventListener('pointerdown', function (event) {
		if (event.pointerType === 'touch') return;
		event.preventDefault();
		showOriginal(true);
	});
	originalBtn.addEventListener('pointerup', function (event) {
		if (event.pointerType === 'touch') return;
		releaseOriginal();
	});
	originalBtn.addEventListener('pointerleave', function (event) {
		if (event.pointerType === 'touch') return;
		releaseOriginal();
	});
	originalBtn.addEventListener('pointercancel', releaseOriginal);
	originalBtn.addEventListener('touchstart', function (event) {
		event.preventDefault();
		showOriginal(true);
	}, { passive: false });
	originalBtn.addEventListener('touchend', releaseOriginal);
	originalBtn.addEventListener('touchcancel', releaseOriginal);
	originalBtn.addEventListener('contextmenu', function (event) {
		event.preventDefault();
	});
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

	function fittedCrop() {
		var pair = cropRatios[cropName];
		if (!pair || !view.width || !view.height) return { w: view.width, h: view.height };
		var w = view.width;
		var h = Math.round(view.width * pair[1] / pair[0]);
		if (h > view.height) {
			h = view.height;
			w = Math.round(view.height * pair[0] / pair[1]);
		}
		return {
			w: Math.max(1, Math.min(view.width, w)),
			h: Math.max(1, Math.min(view.height, h))
		};
	}

	function minCrop() {
		var max = fittedCrop();
		var long = Math.max(max.w, max.h);
		var target = Math.min(long, Math.max(48, Math.round(long * 0.2)));
		var w;
		var h;
		if (max.w >= max.h) {
			w = target;
			h = Math.max(1, Math.round(w * max.h / max.w));
		} else {
			h = target;
			w = Math.max(1, Math.round(h * max.w / max.h));
		}
		if (w > max.w || h > max.h) return { w: max.w, h: max.h };
		return { w: w, h: h };
	}

	function clampCrop() {
		var max = fittedCrop();
		var ratio = max.h ? max.w / max.h : 1;
		if (!cropW || !cropH) {
			cropW = max.w;
			cropH = max.h;
		}
		var min = minCrop();
		cropW = Math.max(min.w, Math.min(max.w, cropW));
		cropH = Math.max(1, Math.round(cropW / ratio));
		if (cropH > max.h) {
			cropH = max.h;
			cropW = Math.max(1, Math.round(cropH * ratio));
		}
		if (cropH < min.h && min.h <= max.h) {
			cropH = min.h;
			cropW = Math.max(1, Math.round(cropH * ratio));
		}
		if (cropX < 0) cropX = 0;
		if (cropY < 0) cropY = 0;
		if (cropX + cropW > view.width) cropX = view.width - cropW;
		if (cropY + cropH > view.height) cropY = view.height - cropH;
		return { w: cropW, h: cropH };
	}

	function centerCrop() {
		var size = fittedCrop();
		cropW = size.w;
		cropH = size.h;
		cropX = Math.round((view.width - cropW) / 2);
		cropY = Math.round((view.height - cropH) / 2);
		return clampCrop();
	}

	function shadeBox(node, x, y, w, h) {
		node.style.left = (x / view.width * 100) + '%';
		node.style.top = (y / view.height * 100) + '%';
		node.style.width = (w / view.width * 100) + '%';
		node.style.height = (h / view.height * 100) + '%';
	}

	function placeCrop() {
		var batch = jobName === 'batch';
		frameSwitch.hidden = !ready || batch;
		var active = ready && !batch && cropName !== 'original';
		cropLayer.hidden = !active;
		frameButtons.forEach(function (button) {
			setChoice(button, button.getAttribute('data-frame') === cropName);
		});
		if (!active) return;
		var size = clampCrop();
		shadeBox(cropShades.top, 0, 0, view.width, cropY);
		shadeBox(cropShades.left, 0, cropY, cropX, size.h);
		shadeBox(cropShades.right, cropX + size.w, cropY, view.width - cropX - size.w, size.h);
		shadeBox(cropShades.bottom, 0, cropY + size.h, view.width, view.height - cropY - size.h);
		shadeBox(cropFrame, cropX, cropY, size.w, size.h);
		cropTag.textContent = cropName;
	}

	function setFrame(name) {
		if (!cropRatios[name] && name !== 'original') return;
		cropName = name;
		if (name !== 'original' && ready) centerCrop();
		placeCrop();
		if (name === 'original') setStatus('Download keeps the whole photo.');
		else setStatus('Drag the frame to move it, or a corner to resize. Download keeps that area.');
	}

	function imagePoint(event) {
		var rect = view.getBoundingClientRect();
		return {
			x: (event.clientX - rect.left) * (view.width / rect.width),
			y: (event.clientY - rect.top) * (view.height / rect.height)
		};
	}

	function resizeFromPointer(event) {
		if (!cropResize) return;
		var point = imagePoint(event);
		var max = fittedCrop();
		var ratio = max.h ? max.w / max.h : 1;
		var corner = cropResize.corner;
		var dw = Math.abs(cropResize.ax - point.x);
		var dh = Math.abs(cropResize.ay - point.y);
		var w = dw;
		var h = w / ratio;
		if (h > dh) {
			h = dh;
			w = h * ratio;
		}
		var roomW = (corner === 'nw' || corner === 'sw') ? cropResize.ax : (view.width - cropResize.ax);
		var roomH = (corner === 'nw' || corner === 'ne') ? cropResize.ay : (view.height - cropResize.ay);
		roomW = Math.max(1, Math.min(roomW, max.w));
		roomH = Math.max(1, Math.min(roomH, max.h));
		if (w > roomW) {
			w = roomW;
			h = w / ratio;
		}
		if (h > roomH) {
			h = roomH;
			w = h * ratio;
		}
		var min = minCrop();
		if (w < min.w || h < min.h) {
			w = min.w;
			h = min.h;
			if (w > roomW || h > roomH) {
				w = Math.min(w, roomW);
				h = w / ratio;
				if (h > roomH) {
					h = roomH;
					w = h * ratio;
				}
			}
		}
		cropW = Math.max(1, Math.round(w));
		cropH = Math.max(1, Math.round(h));
		if (corner === 'nw' || corner === 'sw') cropX = cropResize.ax - cropW;
		else cropX = cropResize.ax;
		if (corner === 'nw' || corner === 'ne') cropY = cropResize.ay - cropH;
		else cropY = cropResize.ay;
		placeCrop();
	}

	frameButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			setFrame(button.getAttribute('data-frame'));
		});
	});
	cropFrame.addEventListener('pointerdown', function (event) {
		if (cropName === 'original' || !ready || cropResize) return;
		if (event.target.closest && event.target.closest('.crop-handle')) return;
		event.preventDefault();
		event.stopPropagation();
		cropDrag = { px: event.clientX, py: event.clientY, x: cropX, y: cropY };
		cropFrame.classList.add('is-dragging');
		cropFrame.setPointerCapture(event.pointerId);
	});
	cropFrame.addEventListener('pointermove', function (event) {
		if (!cropDrag) return;
		event.preventDefault();
		event.stopPropagation();
		var rect = view.getBoundingClientRect();
		cropX = cropDrag.x + (event.clientX - cropDrag.px) * (view.width / rect.width);
		cropY = cropDrag.y + (event.clientY - cropDrag.py) * (view.height / rect.height);
		placeCrop();
	});
	function endCropDrag(event) {
		if (!cropDrag) return;
		cropDrag = null;
		cropFrame.classList.remove('is-dragging');
		if (event) event.stopPropagation();
	}
	cropFrame.addEventListener('pointerup', endCropDrag);
	cropFrame.addEventListener('pointercancel', endCropDrag);
	Array.prototype.forEach.call(cropFrame.querySelectorAll('.crop-handle'), function (handle) {
		handle.addEventListener('pointerdown', function (event) {
			if (cropName === 'original' || !ready) return;
			event.preventDefault();
			event.stopPropagation();
			var corner = handle.getAttribute('data-corner');
			var size = clampCrop();
			cropResize = {
				corner: corner,
				ax: (corner === 'nw' || corner === 'sw') ? cropX + size.w : cropX,
				ay: (corner === 'nw' || corner === 'ne') ? cropY + size.h : cropY
			};
			handle.setPointerCapture(event.pointerId);
		});
		handle.addEventListener('pointermove', function (event) {
			if (!cropResize || event.currentTarget !== handle) return;
			event.preventDefault();
			event.stopPropagation();
			resizeFromPointer(event);
		});
		function endResize(event) {
			if (!cropResize) return;
			cropResize = null;
			if (event) event.stopPropagation();
		}
		handle.addEventListener('pointerup', endResize);
		handle.addEventListener('pointercancel', endResize);
	});

	function downloadCanvas() {
		if (cropName === 'original') return result;
		var size = clampCrop();
		var canvas = document.createElement('canvas');
		canvas.width = size.w;
		canvas.height = size.h;
		canvas.getContext('2d').drawImage(result, cropX, cropY, size.w, size.h, 0, 0, size.w, size.h);
		return canvas;
	}

	function downloadName() {
		var ratioBit = cropName === 'original' ? '' : '-' + cropName.replace(':', 'x');
		return (mode === 'unblur' ? 'unblurred-photo' : 'blurred-image') + ratioBit + '.png';
	}

	downloadBtn.addEventListener('click', function () {
		if (jobName === 'batch') {
			downloadBatch();
			return;
		}
		if (!ready) return;
		var output = downloadCanvas();
		var sizeLabel = output.width + '×' + output.height;
		output.toBlob(function (blob) {
			if (!blob) return;
			saveBlob(blob, downloadName());
			setStatus('Downloaded ' + sizeLabel + ' PNG.');
		}, 'image/png');
	});

	if (jobSingleBtn) jobSingleBtn.addEventListener('click', function () { chooseJob('single'); });
	if (jobBatchBtn) jobBatchBtn.addEventListener('click', function () { chooseJob('batch'); });

	if (focusPoint) {
		focusPoint.addEventListener('pointerdown', function (event) {
			event.preventDefault();
			event.stopPropagation();
			focusDrag = true;
			try { focusPoint.setPointerCapture(event.pointerId); } catch (err) {}
			moveFocus(event);
		});
		focusPoint.addEventListener('pointermove', function (event) {
			if (!focusDrag) return;
			moveFocus(event);
		});
		function stopFocus() {
			if (!focusDrag) return;
			focusDrag = false;
			commitSettings();
		}
		focusPoint.addEventListener('pointerup', stopFocus);
		focusPoint.addEventListener('pointercancel', stopFocus);
	}

	applyPreset();
	effectFromUrl();
	syncLabels();
	updateZoomControls();
	syncJob();
	setStatus(subjectMode
		? 'Click or drag an image here. Then choose what to keep sharp and blur the background.'
		: faceMode
			? 'Click or drag an image here. Then blur the faces.'
			: textMode
				? 'Click or drag an image here. Then blur the text.'
				: presetName === 'soft'
					? 'Click or drag an image here. Brush is ready. Raise Strength, then paint what should be harder to read.'
					: 'Click or drag an image here. Editing stays in this browser.');
})();
