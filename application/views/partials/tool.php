<?php defined('BASEPATH') OR exit('No direct script access allowed');
$mode = $tool['mode'];
$preset = $tool['preset'];
if ( ! function_exists('blur_effect_svg')) {
	function blur_effect_svg($name) {
		$icons = array(
			'gaussian' => '<svg viewBox="0 0 64 36" aria-hidden="true"><defs><radialGradient id="fx-gauss" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#64748b"/><stop offset="55%" stop-color="#94a3b8" stop-opacity=".55"/><stop offset="100%" stop-color="#94a3b8" stop-opacity="0"/></radialGradient></defs><circle cx="32" cy="18" r="16" fill="url(#fx-gauss)"/></svg>',
			'pixel' => '<svg viewBox="0 0 64 36" aria-hidden="true"><rect x="16" y="6" width="8" height="8" fill="#64748b"/><rect x="26" y="6" width="8" height="8" fill="#94a3b8"/><rect x="36" y="6" width="8" height="8" fill="#64748b"/><rect x="16" y="16" width="8" height="8" fill="#94a3b8"/><rect x="26" y="16" width="8" height="8" fill="#475569"/><rect x="36" y="16" width="8" height="8" fill="#94a3b8"/><rect x="16" y="26" width="8" height="6" fill="#64748b"/><rect x="26" y="26" width="8" height="6" fill="#94a3b8"/><rect x="36" y="26" width="8" height="6" fill="#64748b"/></svg>',
			'noise' => '<svg viewBox="0 0 64 36" aria-hidden="true"><circle cx="14" cy="10" r="1.4" fill="#64748b"/><circle cx="22" cy="8" r="1" fill="#94a3b8"/><circle cx="30" cy="12" r="1.6" fill="#475569"/><circle cx="40" cy="7" r="1.1" fill="#64748b"/><circle cx="48" cy="11" r="1.3" fill="#94a3b8"/><circle cx="18" cy="18" r="1.2" fill="#475569"/><circle cx="27" cy="20" r="1" fill="#64748b"/><circle cx="36" cy="17" r="1.5" fill="#94a3b8"/><circle cx="46" cy="21" r="1.1" fill="#475569"/><circle cx="54" cy="16" r="1.2" fill="#64748b"/><circle cx="16" cy="28" r="1" fill="#94a3b8"/><circle cx="25" cy="27" r="1.4" fill="#64748b"/><circle cx="34" cy="30" r="1" fill="#475569"/><circle cx="44" cy="28" r="1.3" fill="#64748b"/><circle cx="52" cy="26" r="1" fill="#94a3b8"/></svg>',
			'motion' => '<svg viewBox="0 0 64 36" aria-hidden="true"><line x1="8" y1="10" x2="56" y2="10" stroke="#64748b" stroke-width="2" stroke-linecap="round"/><line x1="14" y1="18" x2="50" y2="18" stroke="#64748b" stroke-width="2" stroke-linecap="round" opacity=".65"/><line x1="22" y1="26" x2="42" y2="26" stroke="#64748b" stroke-width="2" stroke-linecap="round" opacity=".35"/></svg>',
			'radial' => '<svg viewBox="0 0 64 36" aria-hidden="true"><circle cx="32" cy="18" r="3" fill="#475569"/><circle cx="32" cy="18" r="8" fill="none" stroke="#64748b" stroke-width="1.6"/><circle cx="32" cy="18" r="13" fill="none" stroke="#94a3b8" stroke-width="1.4"/></svg>',
			'color' => '<svg viewBox="0 0 64 36" aria-hidden="true"><rect x="14" y="8" width="28" height="8" rx="2" fill="#ef4444" opacity=".8"/><rect x="20" y="14" width="28" height="8" rx="2" fill="#22c55e" opacity=".75"/><rect x="26" y="20" width="28" height="8" rx="2" fill="#3b82f6" opacity=".75"/></svg>',
			'bar' => '<svg viewBox="0 0 64 36" aria-hidden="true"><rect x="12" y="13" width="40" height="10" rx="2" fill="#111827"/></svg>',
		);
		return isset($icons[$name]) ? $icons[$name] : '';
	}
}
?>
<section class="editor" id="editor" data-mode="<?= html_escape($mode) ?>" data-preset="<?= html_escape($preset) ?>"<?php if ( ! empty($tool['batch'])): ?> data-batch="1"<?php endif; ?><?php if ( ! empty($tool['subject'])): ?> data-subject="1" data-object-model="<?= html_escape(asset_url('models/u2netp.onnx')) ?>"<?php endif; ?><?php if ( ! empty($tool['face'])): ?> data-face="1"<?php endif; ?><?php if ( ! empty($tool['text'])): ?> data-text="1"<?php endif; ?><?php if ( ! empty($tool['effects'])): ?> data-effects="1"<?php endif; ?> aria-label="<?= $mode === 'unblur' ? 'Unblur photo editor' : 'Blur image editor' ?>">
	<?php if ( ! empty($tool['batch'])): ?>
	<div class="job-switch">
		<div class="choice-row" role="radiogroup" aria-label="Single or batch">
			<button type="button" class="choice is-on" id="job-single" aria-pressed="true">Single</button>
			<button type="button" class="choice" id="job-batch" aria-pressed="false">Batch</button>
		</div>
	</div>
	<?php endif; ?>
	<div class="editor-layout">
		<div class="editor-stage">
			<label class="dropzone" id="dropzone">
				<input id="file" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
				<span class="cloud" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 18h10a4 4 0 0 0 .4-8 6 6 0 0 0-11.5-1.5A3.5 3.5 0 0 0 7 18z"/><path d="M12 12v6M9.5 14.5 12 12l2.5 2.5"/></svg>
				</span>
				<span class="drop-title"><?= $mode === 'unblur' ? 'Click or drag a blurry photo here' : 'Click or drag an image here' ?></span>
				<span>JPG, PNG, or WEBP, up to 15 MB. Nothing is uploaded.</span>
				<span class="select-btn">Select Image</span>
			</label>
			<div class="batch" id="batch" hidden></div>
			<?php if ( ! empty($tool['batch'])): ?>
			<button type="button" class="batch-add" id="batch-add" hidden>Add images</button>
			<?php endif; ?>
			<div class="stage" id="stage" hidden>
				<div class="stage-viewport" id="stage-viewport">
					<div class="stage-sizer">
						<div class="stage-canvas" id="stage-canvas">
							<canvas id="view" class="view"></canvas>
							<canvas id="ink" class="ink" aria-hidden="true"></canvas>
							<div class="crop-layer" id="crop-layer" hidden>
								<div class="crop-shade" id="crop-top"></div>
								<div class="crop-shade" id="crop-left"></div>
								<div class="crop-shade" id="crop-right"></div>
								<div class="crop-shade" id="crop-bottom"></div>
								<div class="crop-frame" id="crop-frame">
									<span class="crop-tag" id="crop-tag">9:16</span>
									<button type="button" class="crop-handle" data-corner="nw" aria-label="Resize from top left"></button>
									<button type="button" class="crop-handle" data-corner="ne" aria-label="Resize from top right"></button>
									<button type="button" class="crop-handle" data-corner="sw" aria-label="Resize from bottom left"></button>
									<button type="button" class="crop-handle" data-corner="se" aria-label="Resize from bottom right"></button>
								</div>
							</div>
							<?php if ( ! empty($tool['face'])): ?>
							<div class="face-layer" id="face-layer" hidden></div>
							<?php endif; ?>
							<?php if ( ! empty($tool['text'])): ?>
							<div class="text-layer" id="text-layer" hidden></div>
							<?php endif; ?>
							<?php if ( ! empty($tool['effects'])): ?>
							<div class="focus-layer" id="focus-layer" hidden><button type="button" class="focus-point" id="focus-point" aria-label="Drag the blur center"></button></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php if ( ! empty($tool['subject'])): ?>
				<button type="button" id="mask-toggle" class="mask-toggle" hidden aria-pressed="false" aria-label="Show mask" title="Show mask">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
				</button>
				<?php endif; ?>
			</div>
			<div class="zoom-bar" id="zoom-bar" hidden>
				<button type="button" id="zoom-out-btn" aria-label="Zoom out">−</button>
				<input id="zoom" type="range" min="100" max="400" step="1" value="100" aria-label="Zoom">
				<button type="button" id="zoom-in-btn" aria-label="Zoom in">+</button>
				<output id="zoom-out" class="zoom-readout">100%</output>
				<button type="button" id="zoom-fit">Fit</button>
				<p class="hint">Zoom in and the photo grows to its full height. Scroll sideways, or hold Space and drag, to reach the sides.</p>
			</div>
			<p class="status" id="status" role="status"></p>
			<div class="history-bar" id="history-bar" hidden>
				<button type="button" id="undo" class="icon-btn" disabled title="Undo (Ctrl+Z)" aria-label="Undo">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H12"/></svg>
				</button>
				<button type="button" id="redo" class="icon-btn" disabled title="Redo (Ctrl+Y)" aria-label="Redo">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 14 5-5-5-5"/><path d="M20 9H9.5a5.5 5.5 0 0 0 0 11H12"/></svg>
				</button>
				<button type="button" id="reset-image" class="icon-btn" disabled title="Reset" aria-label="Reset">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
				</button>
				<button type="button" id="replace" class="icon-btn" title="Replace" aria-label="Replace">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m16 3 4 4-4 4"/><path d="M20 7H4"/><path d="m8 21-4-4 4-4"/><path d="M4 17h16"/></svg>
				</button>
				<button type="button" id="remove-image" class="icon-btn" title="Delete" aria-label="Delete">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
				</button>
			</div>
			<?php if (empty($tool['effects'])): ?>
			<div class="frame-switch" id="frame-switch" hidden>
				<span class="control-label" id="frame-label">Download frame</span>
				<div class="frame-row" role="radiogroup" aria-labelledby="frame-label">
					<button type="button" class="choice is-on" data-frame="original" aria-pressed="true">Original</button>
					<button type="button" class="choice" data-frame="9:16" aria-pressed="false">9:16</button>
					<button type="button" class="choice" data-frame="3:4" aria-pressed="false">3:4</button>
					<button type="button" class="choice" data-frame="4:5" aria-pressed="false">4:5</button>
					<button type="button" class="choice" data-frame="1:1" aria-pressed="false">1:1</button>
					<button type="button" class="choice" data-frame="16:9" aria-pressed="false">16:9</button>
				</div>
				<p class="hint">Drag the frame to move it. Drag a corner to resize. Original downloads the whole photo.</p>
			</div>
			<?php endif; ?>
		</div>
		<div class="controls">
			<?php
			$note_below = ! empty($tool['note_below']);
			ob_start();
			?>
			<p class="note" id="editor-note" data-single="<?= html_escape($tool['note']) ?>"<?php if ( ! empty($tool['batch'])): ?> data-batch="Batch uses one blur strength on every whole image. Each photo shows before and after, sized against the largest file."<?php endif; ?>><?= html_escape($tool['note']) ?></p>
			<?php
			$editor_note = ob_get_clean();
			if ( ! $note_below) echo $editor_note;
			?>
			<div class="tune">
			<?php if ( ! empty($tool['subject'])): ?>
			<div class="tune-step" id="auto-group">
				<p class="tune-step-title">Find the subject</p>
				<div class="choice-row" role="radiogroup" aria-label="Find the subject">
					<button type="button" class="choice is-on" id="protect-life" aria-pressed="true">People and animals</button>
					<button type="button" class="choice" id="protect-things" aria-pressed="false">Objects</button>
				</div>
				<p class="hint" id="protect-hint">Edges are rough. Paint anything missed.</p>
				<button type="button" class="primary" id="blur-background" disabled>Blur background</button>
				<div class="auto-progress" id="auto-progress" hidden>
					<div class="auto-progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Working"><div class="auto-progress-bar" id="auto-progress-bar"></div></div>
				</div>
			</div>
			<div class="tune-step" id="refine-group">
				<div class="tune-step-head">
					<p class="tune-step-title">Fix the edge</p>
					<button type="button" class="text-btn is-on" id="subject-auto" aria-pressed="true">Invert selection</button>
				</div>
				<div class="choice-row" role="radiogroup" aria-label="Fix the edge">
					<button type="button" class="choice is-on" id="refine-keep" aria-pressed="true">Keep</button>
					<button type="button" class="choice" id="refine-erase" aria-pressed="false">Erase</button>
				</div>
				<div class="choice-row refine-shapes" role="radiogroup" aria-label="Shape">
					<button type="button" class="choice is-on" id="scope-brush" aria-pressed="true">Brush</button>
					<button type="button" class="choice" id="scope-marquee" aria-pressed="false" title="Rectangular marquee">Marquee</button>
					<button type="button" class="choice" id="scope-lasso" aria-pressed="false" title="Freehand lasso">Lasso</button>
				</div>
				<button type="button" class="choice" id="scope-whole" hidden>Whole image</button>
				<div class="control-group" id="brush-group">
					<label for="brush">Brush size <output id="brush-out">72 px</output></label>
					<input id="brush" type="range" min="8" max="140" value="72">
				</div>
				<div class="control-group" id="feather-group">
					<label for="feather">Feather <output id="feather-out">16 px</output></label>
					<input id="feather" type="range" min="0" max="48" value="16">
				</div>
			</div>
			<div class="tune-step" id="effect-group">
				<p class="tune-step-title">Blur</p>
				<div class="choice-row effect-cards" role="radiogroup" aria-label="Blur">
					<button type="button" class="choice effect-card is-on" id="effect-gaussian" aria-pressed="true"><?= blur_effect_svg('gaussian') ?><span>Gaussian</span></button>
					<button type="button" class="choice effect-card" id="effect-pixel" aria-pressed="false"><?= blur_effect_svg('pixel') ?><span>Pixel</span></button>
					<button type="button" class="choice effect-card" id="effect-noise" aria-pressed="false"><?= blur_effect_svg('noise') ?><span>Noise</span></button>
					<button type="button" class="choice effect-card" id="effect-motion" aria-pressed="false" hidden><?= blur_effect_svg('motion') ?><span>Motion</span></button>
					<button type="button" class="choice effect-card" id="effect-radial" aria-pressed="false" hidden><?= blur_effect_svg('radial') ?><span>Radial</span></button>
					<button type="button" class="choice effect-card" id="effect-color" aria-pressed="false" hidden><?= blur_effect_svg('color') ?><span>Color</span></button>
				</div>
				<div class="control-group">
					<label for="intensity">Strength <output id="intensity-out">18 px</output></label>
					<input id="intensity" type="range" min="0" max="40" value="18">
				</div>
			</div>
			<?php elseif ( ! empty($tool['face'])): ?>
			<div class="tune-step" id="auto-group">
				<p class="tune-step-title">Find the faces</p>
				<p class="hint">Each box is widened past the eyes and chin. Click a box to remove it.</p>
				<button type="button" class="primary" id="blur-faces" disabled>Blur faces</button>
				<div class="auto-progress" id="auto-progress" hidden>
					<div class="auto-progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Working"><div class="auto-progress-bar" id="auto-progress-bar"></div></div>
				</div>
			</div>
			<div class="tune-step" id="effect-group">
				<p class="tune-step-title">Cover</p>
				<div class="choice-row face-effects effect-cards" role="radiogroup" aria-label="Cover">
					<button type="button" class="choice effect-card is-on" id="effect-pixel" aria-pressed="true"><?= blur_effect_svg('pixel') ?><span>Pixel</span></button>
					<button type="button" class="choice effect-card" id="effect-gaussian" aria-pressed="false"><?= blur_effect_svg('gaussian') ?><span>Gaussian</span></button>
					<button type="button" class="choice effect-card" id="effect-bar" aria-pressed="false"><?= blur_effect_svg('bar') ?><span>Black bar</span></button>
				</div>
				<div class="control-group" id="strength-group">
					<label for="intensity">Strength <output id="intensity-out">16 px</output></label>
					<input id="intensity" type="range" min="1" max="40" value="16">
				</div>
				<div class="control-group" id="brush-group">
					<label for="brush">Brush size <output id="brush-out">46 px</output></label>
					<input id="brush" type="range" min="8" max="140" value="46">
				</div>
				<p class="hint">Paint any face the finder missed.</p>
			</div>
			<?php elseif ( ! empty($tool['text'])): ?>
			<div class="tune-step" id="auto-group">
				<p class="tune-step-title">Find the text</p>
				<p class="hint">Red boxes mark the writing. Click a box to remove it. Each box is widened past the letters.</p>
				<button type="button" class="primary" id="blur-text-all" disabled>Auto Blur All Text</button>
				<button type="button" id="blur-text-sensitive" disabled>Blur Sensitive Only</button>
				<div class="auto-progress" id="auto-progress" hidden>
					<div class="auto-progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Working"><div class="auto-progress-bar" id="auto-progress-bar"></div></div>
				</div>
			</div>
			<div class="tune-step" id="effect-group">
				<p class="tune-step-title">Cover</p>
				<div class="choice-row text-effects effect-cards" role="radiogroup" aria-label="Cover">
					<button type="button" class="choice effect-card" id="effect-bar" aria-pressed="false"><?= blur_effect_svg('bar') ?><span>Redact</span></button>
					<button type="button" class="choice effect-card is-on" id="effect-pixel" aria-pressed="true"><?= blur_effect_svg('pixel') ?><span>Pixel</span></button>
					<button type="button" class="choice effect-card" id="effect-gaussian" aria-pressed="false"><?= blur_effect_svg('gaussian') ?><span>Blur</span></button>
				</div>
				<div class="choice-row" id="redact-tones" hidden role="radiogroup" aria-label="Redact color">
					<button type="button" class="choice is-on" id="redact-black" aria-pressed="true">Black</button>
					<button type="button" class="choice" id="redact-gray" aria-pressed="false">Gray</button>
				</div>
				<div class="control-group" id="strength-group">
					<label for="intensity">Strength <output id="intensity-out">16 px</output></label>
					<input id="intensity" type="range" min="1" max="40" value="16">
				</div>
				<p class="hint">Redact is a solid block for passwords, card numbers, and IDs. Pixel and Blur can still show the shape of large type.</p>
			</div>
			<div class="tune-step">
				<p class="tune-step-title">Add missed text</p>
				<div class="choice-row" role="radiogroup" aria-label="Add missed text">
					<button type="button" class="choice is-on" id="scope-marquee" aria-pressed="true">Marquee</button>
					<button type="button" class="choice" id="scope-brush" aria-pressed="false">Brush</button>
				</div>
				<div class="control-group" id="brush-group" hidden>
					<label for="brush">Brush size <output id="brush-out">26 px</output></label>
					<input id="brush" type="range" min="8" max="140" value="26">
				</div>
				<p class="hint">Drag a rectangle or paint handwriting and any writing the finder missed.</p>
			</div>
			<?php elseif ( ! empty($tool['effects'])): ?>
			<div class="control-group" id="effect-group" data-for="blur">
				<span class="control-label" id="effect-label">Blur effect</span>
				<div class="choice-row effect-cards" role="radiogroup" aria-labelledby="effect-label">
					<button type="button" class="choice effect-card is-on" id="effect-gaussian" aria-pressed="true"><?= blur_effect_svg('gaussian') ?><span>Gaussian</span></button>
					<button type="button" class="choice effect-card" id="effect-pixel" aria-pressed="false"><?= blur_effect_svg('pixel') ?><span>Pixel</span></button>
					<button type="button" class="choice effect-card" id="effect-noise" aria-pressed="false"><?= blur_effect_svg('noise') ?><span>Noise</span></button>
					<button type="button" class="choice effect-card" id="effect-motion" aria-pressed="false"><?= blur_effect_svg('motion') ?><span>Motion</span></button>
					<button type="button" class="choice effect-card" id="effect-radial" aria-pressed="false"><?= blur_effect_svg('radial') ?><span>Radial</span></button>
					<button type="button" class="choice effect-card" id="effect-color" aria-pressed="false"><?= blur_effect_svg('color') ?><span>Color</span></button>
				</div>
			</div>
			<div class="control-group" data-for="blur">
				<span class="control-label" id="scope-label">Apply to</span>
				<div class="choice-row" role="radiogroup" aria-labelledby="scope-label">
					<button type="button" class="choice is-on" id="scope-whole" aria-pressed="true">Whole image</button>
					<button type="button" class="choice" id="scope-brush" aria-pressed="false">Brush</button>
					<button type="button" class="choice" id="scope-marquee" aria-pressed="false" title="Rectangular marquee">Marquee</button>
					<button type="button" class="choice" id="scope-lasso" aria-pressed="false" title="Freehand lasso">Lasso</button>
				</div>
			</div>
			<div class="control-group" id="strength-group" data-for="blur">
				<label for="intensity"><span id="intensity-name">Strength</span> <output id="intensity-out">8 px</output></label>
				<input id="intensity" type="range" min="0" max="40" value="8">
			</div>
			<div class="control-group" id="motion-group" hidden>
				<label for="motion-angle">Angle <output id="motion-angle-out">0°</output></label>
				<input id="motion-angle" type="range" min="0" max="360" step="1" value="0">
			</div>
			<p class="hint" id="radial-hint" hidden>Drag the point on the photo to move the center.</p>
			<div class="control-group" id="brush-group" hidden>
				<label for="brush">Brush size <output id="brush-out">48 px</output></label>
				<input id="brush" type="range" min="8" max="140" value="48">
			</div>
			<div class="control-group" id="feather-group" hidden>
				<label for="feather">Feather <output id="feather-out">0 px</output></label>
				<input id="feather" type="range" min="0" max="48" value="0">
			</div>
			<details class="frame-switch frame-disclosure" id="frame-switch" hidden>
				<summary id="frame-label">Download frame</summary>
				<div class="frame-row" role="radiogroup" aria-labelledby="frame-label">
					<button type="button" class="choice is-on" data-frame="original" aria-pressed="true">Original</button>
					<button type="button" class="choice" data-frame="9:16" aria-pressed="false">9:16</button>
					<button type="button" class="choice" data-frame="3:4" aria-pressed="false">3:4</button>
					<button type="button" class="choice" data-frame="4:5" aria-pressed="false">4:5</button>
					<button type="button" class="choice" data-frame="1:1" aria-pressed="false">1:1</button>
					<button type="button" class="choice" data-frame="16:9" aria-pressed="false">16:9</button>
				</div>
				<p class="hint">Drag the frame to move it. Drag a corner to resize. Original downloads the whole photo.</p>
			</details>
			<?php else: ?>
			<div class="control-group" id="effect-group" data-for="blur">
				<span class="control-label" id="effect-label">Blur effect</span>
				<div class="choice-row effect-cards" role="radiogroup" aria-labelledby="effect-label">
					<button type="button" class="choice effect-card is-on" id="effect-gaussian" aria-pressed="true"><?= blur_effect_svg('gaussian') ?><span>Gaussian</span></button>
					<button type="button" class="choice effect-card" id="effect-pixel" aria-pressed="false"><?= blur_effect_svg('pixel') ?><span>Pixel</span></button>
					<button type="button" class="choice effect-card" id="effect-noise" aria-pressed="false"><?= blur_effect_svg('noise') ?><span>Noise</span></button>
					<?php if (empty($tool['basic'])): ?>
					<button type="button" class="choice effect-card" id="effect-motion" aria-pressed="false"><?= blur_effect_svg('motion') ?><span>Motion</span></button>
					<button type="button" class="choice effect-card" id="effect-radial" aria-pressed="false"><?= blur_effect_svg('radial') ?><span>Radial</span></button>
					<button type="button" class="choice effect-card" id="effect-color" aria-pressed="false"><?= blur_effect_svg('color') ?><span>Color</span></button>
					<?php endif; ?>
				</div>
			</div>
			<div class="control-group" data-for="blur">
				<span class="control-label" id="scope-label">Apply to</span>
				<div class="choice-row" role="radiogroup" aria-labelledby="scope-label">
					<button type="button" class="choice<?php if (empty($tool['basic'])): ?> is-on<?php endif; ?>" id="scope-whole" aria-pressed="<?= empty($tool['basic']) ? 'true' : 'false' ?>">Whole image</button>
					<button type="button" class="choice<?php if ( ! empty($tool['basic'])): ?> is-on<?php endif; ?>" id="scope-brush" aria-pressed="<?= ! empty($tool['basic']) ? 'true' : 'false' ?>">Brush</button>
					<button type="button" class="choice" id="scope-marquee" aria-pressed="false" title="Rectangular marquee">Marquee</button>
					<button type="button" class="choice" id="scope-lasso" aria-pressed="false" title="Freehand lasso">Lasso</button>
				</div>
			</div>
			<div class="control-group" data-for="blur">
				<label for="intensity">Strength <output id="intensity-out">0 px</output></label>
				<input id="intensity" type="range" min="0" max="40" value="0">
			</div>
			<div class="control-group" id="brush-group"<?php if (empty($tool['basic'])): ?> hidden<?php endif; ?>>
				<label for="brush">Brush size <output id="brush-out">48 px</output></label>
				<input id="brush" type="range" min="8" max="140" value="48">
			</div>
			<div class="control-group" id="feather-group"<?php if (empty($tool['basic'])): ?> hidden<?php endif; ?>>
				<label for="feather">Feather <output id="feather-out">0 px</output></label>
				<input id="feather" type="range" min="0" max="48" value="0">
			</div>
			<?php endif; ?>
			<div class="control-group" data-for="unblur">
				<label for="sharpen">Clarity <output id="sharpen-out"></output></label>
				<input id="sharpen" type="range" min="0" max="250" value="110">
			</div>
			<div class="control-group" data-for="unblur">
				<label for="radius">Sharpen radius <output id="radius-out"></output></label>
				<input id="radius" type="range" min="1" max="8" step="0.1" value="1.4">
			</div>
			<div class="control-group" data-for="unblur">
				<label for="contrast">Contrast <output id="contrast-out"></output></label>
				<input id="contrast" type="range" min="0" max="40" value="8">
			</div>
			</div>
			<div class="button-row">
				<?php if ($mode === 'unblur'): ?>
				<button type="button" id="sample">Load sample</button>
				<?php endif; ?>
				<?php if ( ! empty($tool['batch'])): ?>
				<button type="button" id="batch-clear" hidden>Clear</button>
				<?php endif; ?>
				<button type="button" id="original" disabled>Hold for original</button>
				<button type="button" id="download" class="primary" disabled>Download</button>
			</div>
			<?php if ($note_below) echo $editor_note; ?>
		</div>
	</div>
</section>
