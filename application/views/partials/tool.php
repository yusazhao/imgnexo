<?php defined('BASEPATH') OR exit('No direct script access allowed');
$mode = $tool['mode'];
$preset = $tool['preset'];
?>
<section class="editor" id="editor" data-mode="<?= html_escape($mode) ?>" data-preset="<?= html_escape($preset) ?>"<?php if ( ! empty($tool['batch'])): ?> data-batch="1"<?php endif; ?> aria-label="<?= $mode === 'unblur' ? 'Unblur photo editor' : 'Blur image editor' ?>">
	<?php if ( ! empty($tool['steps'])): ?>
	<ol class="steps">
		<?php foreach ($tool['steps'] as $step): ?>
		<li><?= html_escape($step) ?></li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>
	<div class="editor-layout">
		<div class="editor-stage">
			<div class="history-bar" id="history-bar">
				<button type="button" id="undo" disabled title="Undo (Ctrl+Z)">Undo</button>
				<button type="button" id="redo" disabled title="Redo (Ctrl+Y)">Redo</button>
				<button type="button" id="reset-image" disabled>Reset image</button>
			</div>
			<label class="dropzone" id="dropzone">
				<input id="file" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
				<span class="cloud" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 18h10a4 4 0 0 0 .4-8 6 6 0 0 0-11.5-1.5A3.5 3.5 0 0 0 7 18z"/><path d="M12 12v6M9.5 14.5 12 12l2.5 2.5"/></svg>
				</span>
				<span class="drop-title"><?= $mode === 'unblur' ? 'Click or drag a blurry photo here' : 'Click or drag an image here' ?></span>
				<span>JPG, PNG, or WEBP. Nothing is uploaded.</span>
				<span class="select-btn">Select Image</span>
			</label>
			<div class="batch" id="batch" hidden></div>
			<div class="stage" id="stage" hidden>
				<div class="stage-viewport" id="stage-viewport">
					<div class="stage-sizer">
						<div class="stage-canvas" id="stage-canvas">
							<canvas id="view" class="view"></canvas>
							<canvas id="ink" class="ink" aria-hidden="true"></canvas>
						</div>
					</div>
				</div>
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
		</div>
		<div class="controls">
			<p class="note" id="editor-note" data-single="<?= html_escape($tool['note']) ?>"<?php if ( ! empty($tool['batch'])): ?> data-batch="Batch uses one Gaussian or Pixel strength on every whole image. Hold a photo to compare it with the original."<?php endif; ?>><?= html_escape($tool['note']) ?></p>
			<?php if ( ! empty($tool['batch'])): ?>
			<div class="control-group">
				<span class="control-label" id="job-label">Edit</span>
				<div class="choice-row" role="radiogroup" aria-labelledby="job-label">
					<button type="button" class="choice is-on" id="job-single" aria-pressed="true">Single</button>
					<button type="button" class="choice" id="job-batch" aria-pressed="false">Batch</button>
				</div>
			</div>
			<?php endif; ?>
			<div class="control-group" data-for="blur">
				<span class="control-label" id="effect-label">Blur effect</span>
				<div class="choice-row" role="radiogroup" aria-labelledby="effect-label">
					<button type="button" class="choice is-on" id="effect-gaussian" aria-pressed="true">Gaussian</button>
					<button type="button" class="choice" id="effect-pixel" aria-pressed="false">Pixel</button>
				</div>
			</div>
			<div class="control-group" data-for="blur">
				<span class="control-label" id="scope-label">Apply to</span>
				<div class="choice-row" role="radiogroup" aria-labelledby="scope-label">
					<button type="button" class="choice is-on" id="scope-whole" aria-pressed="true">Whole image</button>
					<button type="button" class="choice" id="scope-brush" aria-pressed="false">Brush</button>
				</div>
			</div>
			<div class="control-group" data-for="blur">
				<label for="intensity">Strength <output id="intensity-out">0 px</output></label>
				<input id="intensity" type="range" min="0" max="40" value="0">
			</div>
			<div class="control-group" id="brush-group" hidden>
				<label for="brush">Brush size <output id="brush-out">48 px</output></label>
				<input id="brush" type="range" min="8" max="140" value="48">
			</div>
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
			<div class="button-row">
				<button type="button" id="sample">Load sample</button>
				<button type="button" id="replace" hidden>Replace image</button>
				<button type="button" id="original" disabled>Hold for original</button>
				<button type="button" id="download" class="primary" disabled>Download</button>
			</div>
		</div>
	</div>
</section>
