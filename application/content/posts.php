<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return array(
	array(
		'slug' => 'how-to-make-picture-blurry',
		'path' => 'blog/how-to-make-picture-blurry',
		'date' => '2026-04-02',
		'title' => 'How to Make a Picture Blurry Online',
		'description' => 'Make a picture blurry online with gaussian blur, pixelate, or a painted region. No app install, and the photo stays in the browser.',
		'h1' => 'How to Make a Picture Blurry Online',
		'excerpt' => 'A practical way to make a picture blurry on purpose, either across the whole frame or only where a face or some text should disappear.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Make a picture blurry', 'path' => 'blog/how-to-make-picture-blurry'),
		),
		'html' => <<<'HTML'
<p>People make a picture blurry for spoilers, for a thumbnail, or to hide one private detail. The goal is added softness. If your photo is already a blurry photo and you want it sharper, this is the wrong guide. Use <a href="{{path:unblur-image}}">unblur image</a> instead.</p>
<h2>Decide what should become hard to see</h2>
<p>Blurring the entire frame is the fastest option when the whole scene is the secret. Blurring one region is better when the rest of the picture should stay useful. A license plate, a badge, and a bystander are region jobs. Open the <a href="{{path:blur-image}}">blur image</a> editor, upload the file, and set Apply to Brush only if you need that limit.</p>
<h2>Pick Gaussian or Pixel</h2>
<p>Gaussian blur looks smooth and is enough for a teaser. Pixel is stronger when someone might try to read the hidden part. The <a href="{{path:blur-image/effect}}">blur effect</a> page uses one of those at a time. It does not wash the photo toward a fade, and it does not add motion streaks. For a backdrop-only pass, follow <a href="{{path:blur-image/background}}">blur background of photo</a>.</p>
<h2>Check the download, not just the preview</h2>
<p>Download the PNG and open it outside the editor. Look for a sharp island you missed: an ear, a digit, a reflection in a window. The original on your device is unchanged unless you overwrite it. You can <a href="{{path:blur-image/online}}">blur picture online</a> again if the first pass was too light.</p>
HTML
	),
	array(
		'slug' => 'how-to-remove-blur-from-photo',
		'path' => 'blog/how-to-remove-blur-from-photo',
		'date' => '2026-04-16',
		'title' => 'How to Remove Blur From a Photo Without Software',
		'description' => 'Remove blur from a photo in the browser with a careful clarity pass, and know when the file cannot get sharper.',
		'h1' => 'How to Remove Blur From a Photo Without Software',
		'excerpt' => 'How to remove blur from photo files without installing a desktop editor, and when to stop because the detail is gone.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Remove blur from photo', 'path' => 'blog/how-to-remove-blur-from-photo'),
		),
		'html' => <<<'HTML'
<p>Removing blur without software means using the browser you already have. The <a href="{{path:unblur-image}}">unblur image</a> page sharpens edges locally. It does not send the picture anywhere, and it does not promise a new photograph.</p>
<h2>Start from the largest file</h2>
<p>A chat preview is a bad source. Export or airdrop the original, then upload that. Remove blur from photo detail only if edges still exist. If the subject is a smooth shape, clarity will draw a halo around it and call that an improvement.</p>
<h2>Use a small radius first</h2>
<p>Raise clarity until the subject separates from the background, then stop. A larger radius grabs more of the blur but also rings high-contrast edges. Hold the original control every time you change a slider. Keep the download only when it is actually clearer.</p>
<h2>Do not confuse this with adding blur</h2>
<p>Remove blur from image work is the opposite of a <a href="{{path:blur-image}}">blur image</a> edit. If you meant to hide a face, sharpening will make that face easier to recognize. For repair examples across snapshots, see <a href="{{path:unblur-image/photos}}">fix blurry photos</a>.</p>
HTML
	),
	array(
		'slug' => 'how-to-fix-fuzzy-photos',
		'path' => 'blog/how-to-fix-fuzzy-photos',
		'date' => '2026-05-07',
		'title' => 'How to Fix Fuzzy Photos for Old Snapshots',
		'description' => 'Fix fuzzy photos and old scans with a light clarity pass, without turning film grain into harsh outlines.',
		'h1' => 'How to Fix Fuzzy Photos for Old Snapshots',
		'excerpt' => 'Old snapshots and scans need a lighter hand than a modern soft selfie. Here is how to fix fuzzy photos without carving the grain.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Fix fuzzy photos', 'path' => 'blog/how-to-fix-fuzzy-photos'),
		),
		'html' => <<<'HTML'
<p>Fuzzy old photos are often soft because of the lens, the print, or the scan, all at once. You can fix fuzzy photos a little. You should not expect a modern camera file to appear inside a 1970s print.</p>
<h2>Separate scan blur from print blur</h2>
<p>If the print looks sharper than the file, rescan before you edit. Sharpening a bad scan just makes a sharper copy of the wrong blur. When the print itself is soft, a modest pass on <a href="{{path:unblur-image/photos}}">fix blurry photos</a> is the ceiling.</p>
<h2>Keep grain looking like grain</h2>
<p>High radius finds every speck and outlines it. For old snapshots, prefer a lower radius and less contrast. Skin, sky, and blank walls show the damage first. If those areas start to ripple, undo the last increase.</p>
<h2>Archive the untouched scan</h2>
<p>Save the clarity PNG beside the original. Do not replace the scan. A later tool might do a better job, but only if you still have the file you started with. The general limits are the same as any <a href="{{path:unblur-image}}">blurry photo</a> repair on this site.</p>
HTML
	),
	array(
		'slug' => 'gaussian-blur-guide',
		'path' => 'blog/gaussian-blur-guide',
		'date' => '2026-05-21',
		'title' => 'Gaussian Blur Complete Guide for Beginners',
		'description' => 'What gaussian blur does, how it differs from pixelate blur, and when to use each on a photo.',
		'h1' => 'Gaussian Blur Complete Guide for Beginners',
		'excerpt' => 'Gaussian blur is the smooth soften behind most blur sliders. This guide explains what it changes and when pixelate is the better mask.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Gaussian blur guide', 'path' => 'blog/gaussian-blur-guide'),
		),
		'html' => <<<'HTML'
<p>Gaussian blur is a weighted average. Pixels near an edge mix with their neighbors, and nearer neighbors count more than far ones. The result looks soft instead of blocky. It is the effect behind the blur slider on the <a href="{{path:blur-image/effect}}">blur effect</a> page.</p>
<h2>What the radius actually changes</h2>
<p>A small radius is a slight defocus, useful for a busy background or a gentle portrait. A large radius turns the picture into broad color shapes. Privacy is not guaranteed at a small radius: a face can still be recognized. If recognition is the risk, switch to Pixel instead of stacking it under Gaussian.</p>
<h2>Gaussian blur versus pixelate</h2>
<p>Gaussian blur hides by mixing. Pixelate hides by replacing a neighborhood with one flat color. Mixing can be reversed a little by sharpening, which is why it is a weak privacy tool. Blocks throw away the variation inside each cell. For faces, start with pixelate on <a href="{{path:blur-image/face}}">blur face in photo</a>.</p>
<h2>Where beginners should use it</h2>
<p>Use gaussian blur for atmosphere, for a product backdrop, and for spoilers where a hint of the scene is fine. Use the <a href="{{path:blur-image}}">blur image</a> editor to try a value, hold the original, and keep the download that matches the job. Do not use it to repair a blurry photo. That is the opposite direction.</p>
HTML
	),
	array(
		'slug' => 'how-to-blur-face-in-photo',
		'path' => 'blog/how-to-blur-face-in-photo',
		'date' => '2026-06-11',
		'title' => 'How to Blur a Face in a Photo for Privacy',
		'description' => 'Blur a face in a photo so a person cannot be identified. Cover the whole head, prefer pixelate, and check reflections.',
		'h1' => 'How to Blur a Face in a Photo for Privacy',
		'excerpt' => 'Privacy blur fails when an eye, an ear, or a reflection stays sharp. Cover the whole head and check the download.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Blur a face', 'path' => 'blog/how-to-blur-face-in-photo'),
		),
		'html' => <<<'HTML'
<p>Blurring a face is a publishing decision. Do it before the picture is posted, not after people have saved a sharp copy. The editor is on <a href="{{path:blur-image/face}}">blur face in photo</a>.</p>
<h2>Paint past the features</h2>
<p>Cover hairline, ears, chin, and neck if the person is still recognizable from those. Glasses and distinctive earrings can identify someone even when the eyes are blocked. Paint them too.</p>
<h2>Prefer pixelate for strangers</h2>
<p>A light gaussian blur looks polite and often fails. Pixelate until you would not know the person. If the photo is of someone who agreed to a softer look, a low blur is a style choice, not a privacy control.</p>
<h2>Look for second copies of the face</h2>
<p>Mirrors, windows, and phone screens repeat a face. A name tag repeats an identity in text. Blur those in the same pass, using <a href="{{path:blur-image/text}}">blur writing in photo</a> for the letters. Download and inspect at full size. The <a href="{{path:blur-image}}">blur image</a> tool does not change your original file.</p>
HTML
	),
	array(
		'slug' => 'unblur-motion-blur-photo',
		'path' => 'blog/unblur-motion-blur-photo',
		'date' => '2026-07-02',
		'title' => 'Can You Unblur a Motion Blur Photo? Limits and Tips',
		'description' => 'Motion blur can sometimes be tightened, but a streaked subject cannot be fully rebuilt from one frame.',
		'h1' => 'Can You Unblur a Motion Blur Photo? Limits and Tips',
		'excerpt' => 'Short camera shake may improve. A subject that moved through the frame usually cannot be put back together.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Motion blur limits', 'path' => 'blog/unblur-motion-blur-photo'),
		),
		'html' => <<<'HTML'
<p>You can try to unblur a motion blur photo. You should know the limit first: the sharp moment was averaged along a path. A slider can emphasize what is left. It cannot choose the position the subject used to occupy.</p>
<h2>Short shake versus a moving subject</h2>
<p>If the whole frame is slightly doubled, a clarity pass on <a href="{{path:unblur-image/motion-blur}}">motion blur photo</a> may help. If only the person is streaked and the room is sharp, the person moved. Sharpening will trace the streak. It will not invent a still pose.</p>
<h2>Stop when halos show up</h2>
<p>Motion settings use a stronger clarity value, so bright edges grow a pale outline quickly. Compare against the original. If the outline is the main change you see, the repair did not work. Keep the camera file.</p>
<h2>Shoot the next frame differently</h2>
<p>More light, a faster shutter, and a braced camera prevent the blur you are trying to undo. For ordinary soft focus that is not a streak, use <a href="{{path:unblur-image/photos}}">fix blurry photos</a> instead of the motion preset.</p>
HTML
	),
	array(
		'slug' => 'how-to-blur-writing-in-photo',
		'path' => 'blog/how-to-blur-writing-in-photo',
		'date' => '2026-08-14',
		'title' => 'How to Blur Writing in a Photo',
		'description' => 'Blur writing in a photo so account numbers, addresses, and messages cannot be read, including partial characters.',
		'h1' => 'How to Blur Writing in a Photo',
		'excerpt' => 'Cover every character, not just the middle of the word. Partial letters are often enough to reconstruct the rest.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Blur writing', 'path' => 'blog/how-to-blur-writing-in-photo'),
		),
		'html' => <<<'HTML'
<p>Writing in a photo is high risk because it is designed to be read. A light blur that looks dirty on screen can still be readable on a larger monitor. Use <a href="{{path:blur-image/text}}">blur writing in photo</a> and assume someone will zoom.</p>
<h2>Paint the full line</h2>
<p>Include commas, dots, and the tops of tall letters. Leave no character at the end of a line. Account numbers and addresses are readable from a fragment, so cover the entire string even if only part of it feels sensitive.</p>
<h2>Pixelate large type</h2>
<p>Headlines and whiteboards need pixelate, not only gaussian blur. Blocks remove the stroke shapes that a soft blur keeps. If a face sits next to the text, handle it with <a href="{{path:blur-image/face}}">blur face in photo</a> before you publish.</p>
<h2>Keep the original private</h2>
<p>The editor downloads a new PNG and leaves the source file in place. Do not upload the original to the same post by mistake. The general editor is <a href="{{path:blur-image}}">blur image</a> if you also need background or full-frame blur.</p>
HTML
	),
	array(
		'slug' => 'what-is-blur-removal',
		'path' => 'blog/what-is-blur-removal',
		'date' => '2026-09-03',
		'title' => 'What Is Blur Removal and How Does It Work?',
		'description' => 'Blur removal sharpens edges that are still in the file. It does not restore detail a camera never captured.',
		'h1' => 'What Is Blur Removal and How Does It Work?',
		'excerpt' => 'Blur removal on this site is an unsharp mask plus contrast. Here is what that changes, and what it leaves alone.',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blog', 'path' => 'blog'),
			array('name' => 'Blur removal', 'path' => 'blog/what-is-blur-removal'),
		),
		'html' => <<<'HTML'
<p>Blur removal is the attempt to make a soft photo look sharper. On this site it is not a generative fill and it is not a promise that every blurry photo can be saved. The control lives on <a href="{{path:unblur-image}}">unblur image</a>.</p>
<h2>What the math is doing</h2>
<p>The editor blurs a copy of the picture, compares it with the original, and adds the difference back. Edges, where the difference is large, get stronger. Flat areas change less. A contrast slider then stretches the tones. That is why fine detail can look crisper and why halos appear if you push it.</p>
<h2>What it cannot see</h2>
<p>If neighboring pixels were averaged for good, the difference between the original and a further blur is small and noisy. Amplifying it does not recreate a license plate or a pupil. Motion streaks have the extra problem that the edge is in the wrong place. Read <a href="{{path:blog/unblur-motion-blur-photo}}">motion blur limits</a> before you spend time on a streaked frame.</p>
<h2>Use the matching tool</h2>
<p>Blur removal is only for pictures that should become clearer. Adding Gaussian or Pixel blur is <a href="{{path:blur-image}}">blur image</a>. Mixing those jobs on one page confuses both the edit and the reason you opened the file.</p>
HTML
	),
);
