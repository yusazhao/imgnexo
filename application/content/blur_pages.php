<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return array(
	array(
		'group' => 'blur',
		'slug' => 'index',
		'path' => 'blur-image',
		'title' => 'Blur Image Online – Add Blur Effect to Pictures & Photos',
		'description' => 'Free online tool to blur image, blur pic, add blur for pictures. Apply blur on image, make photos blurry in seconds.',
		'h1' => 'Blur Image Online – Add Blur Effect to Pictures & Photos',
		'lead' => '<p>Blur a picture in your browser when part of the frame should be harder to read. Brush is selected, so you can paint a face, some text, or a busy background, then raise Strength. Gaussian softens, Pixel blocks, and Noise scatters. Batch applies that same whole-image blur to several photos. Motion and radial effects are on the <a href="{{path:blur-image/effect}}">blur effect</a> page. The originals stay on your device.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'soft',
			'heading' => 'How to Blur an Image Online',
			'intro' => '<p>The photo stays in your browser. Choose Single for one picture, including a brush stroke, or Batch when several pictures should get the same whole-image blur. Download a PNG, or one zip of every image.</p>',
			'batch' => TRUE,
			'basic' => TRUE,
			'note_below' => TRUE,
			'shortcuts' => array(
				array('path' => 'blur-image/background', 'label' => 'Blur Background'),
				array('path' => 'blur-image/face', 'label' => 'Blur Face'),
				array('path' => 'blur-image/text', 'label' => 'Blur Text'),
				array('path' => 'blur-image/effect', 'label' => 'Blur Effects'),
			),
			'note' => 'Brush is ready. Gaussian softens, Pixel blocks detail, and Noise scatters pixels. Raise Strength, then paint. Marquee and Lasso cover a box or a freehand shape.',
			'steps' => array(
				'Choose Single or Batch, then upload a JPG, PNG, or WEBP.',
				'Brush is selected. Raise Strength, then paint the part that should be harder to read. Marquee and Lasso cover a box or a freehand shape. Batch covers every whole image.',
				'On Single, hold “Hold for original”, then download the whole photo or the frame you placed. Batch downloads every image in one zip.',
			),
		),
		'sections' => array(
			array(
				'h2' => 'Blur Picture Background',
				'html' => '<p>A soft backdrop keeps a person or product easier to see. People look for blur background of photo, blur picture background, and blur image background when a busy street or room is stealing attention.</p><p>The dedicated walkthrough is on the <a href="{{path:blur-image/background}}">blur background of photo</a> page. Choose people and animals, or the main object, then blur the background. Paint anything the finder misses.</p>',
				'children' => array(
					array(
						'h3' => 'Different Ways to Blur Photo Background',
						'html' => '<p>A wide gaussian blur looks like a shallow depth of field. On a single image, paint the subject and leave Invert on so the room softens around it. Batch softens every whole photo the same way, then downloads them in one zip.</p>',
					),
				),
			),
			array(
				'h2' => 'Blur Face in Photo',
				'html' => '<p>Blur face in photo when someone did not agree to be published. The same control covers blur a face in a picture and photo blur face: paint the head, then raise pixelate or blur until features are gone.</p><p>See <a href="{{path:blur-image/face}}">blur face in photo</a> for privacy steps, including more than one person in the frame.</p>',
			),
			array(
				'h2' => 'Blur Text on Image',
				'html' => '<p>A blur text image edit hides writing without cropping the shot. Use it for blur writing in photo cases such as a letter, a badge, a whiteboard, or a chat screenshot.</p><p>The <a href="{{path:blur-image/text}}">blur writing in photo</a> page shows how to cover every character, not just the middle of a word.</p>',
			),
			array(
				'h2' => 'Blur Effect on Photos & Pictures',
				'html' => '<p>A blur effect on pictures can be a light soft-focus look or a heavy blur effect on photos. Blur effect image settings are on the <a href="{{path:blur-image/effect}}">blur effect</a> page. Gaussian, pixelate, motion, radial, noise, and color are there, one at a time.</p>',
			),
			array(
				'h2' => 'Make Picture Blurry',
				'html' => '<p>Make picture blurry when the whole frame should be hard to inspect: a teaser, a spoiler cover, or a placeholder. The same slider lets you make image blurry or make a pic blurry. For make images blurry across a series, switch the editor to Batch: one strength covers every whole photo, then one zip downloads them. This blurry image maker is also the blurry picture maker for a one-off edit.</p>',
			),
			array(
				'h2' => 'Online Blur Image Tool',
				'html' => '<p>You can blur image online, blur picture online, or blur pic online without installing software. Open the <a href="{{path:blur-image/online}}">browser editor</a>, drop the file, and download the result. Nothing is stored on a server.</p>',
			),
			array(
				'h2' => 'Image Blurring Tool & Photo Blur App',
				'html' => '<p>This image blurring tool works as a photo blur tool and a picture blur tool in the browser, so a separate blur image app or blurry pic app is optional. If you were looking for a blur photo editing app, start here and skip the install. A photo that is already soft belongs on <a href="{{path:unblur-image}}">unblur image</a>.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'How do I blur out picture?', 'a' => '<p>Upload the file, choose Gaussian or Pixel, and raise Strength until the detail you care about disappears. Download the PNG. To blur out picture content in only one spot, set Apply to Brush and stroke that area.</p>'),
			array('q' => 'How can I blur out photo?', 'a' => '<p>Open the editor, choose the photo, and blur out photo regions that show a face, a plate, or private writing. Hold the original button if you want to confirm you did not soften the wrong part.</p>'),
			array('q' => 'How to blur out image?', 'a' => '<p>To blur out image detail, use gaussian blur for a smooth cover or pixelate for blocks. Pixelate is harder to reverse by squinting at the file.</p>'),
			array('q' => 'What is gaussian blur?', 'a' => '<p>Gaussian blur averages nearby pixels with a bell-curve falloff, so edges melt instead of turning into squares. The blur slider on this page is that style of soften. A longer guide is in <a href="{{path:blog/gaussian-blur-guide}}">the gaussian blur article</a>.</p>'),
			array('q' => 'How to use pixelate blur on pictures?', 'a' => '<p>Choose Pixel and raise Strength. At 1 the picture stays as it is. Larger blocks hide faces and text more reliably than a light Gaussian soften. Pixel and Gaussian are separate, so switch effects instead of stacking them.</p>'),
			array('q' => 'Can I blur image for WhatsApp?', 'a' => '<p>Yes. Edit first, download the PNG, then send that file in WhatsApp. Blurring inside this page does not connect to WhatsApp. A whatsapp blur image search usually means you want the censored file before you attach it to a chat.</p>'),
			array('q' => 'What does fade images effect do?', 'a' => '<p>Fade images washes a photo toward a pale tone so contrast drops. It is not a privacy mask, and this editor does not include it. Use Gaussian to soften or Pixel to block a face or a line of text.</p>'),
			array('q' => 'Where can I get a blurry picture maker?', 'a' => '<p>This page is the blurry picture maker. Use the editor above, then download. You do not need a separate account.</p>'),
			array('q' => 'Is there a blurry image maker for quick edits?', 'a' => '<p>Yes. The blurry image maker above is a short edit: upload, choose Gaussian or Pixel, set Strength, download. For a face-only or text-only pass, set Apply to Brush.</p>'),
			array('q' => 'What is the difference between blur pic and blur picture?', 'a' => '<p>Blur pic and blur picture are the same request. So are blur and image, blur for pictures, and the common misspelling blure picture. All of them mean you want the photograph softened or partly hidden, not sharpened.</p>'),
			array('q' => 'Can I apply blur for pictures without download app?', 'a' => '<p>Yes. Blur for pictures in this browser and download only the finished PNG. There is no app to install.</p>'),
			array('q' => 'How to put blur on image easily?', 'a' => '<p>To put blur on image, drop the file on the editor, choose Gaussian or Pixel, and move Strength. Set Apply to Brush when only a license plate, a face, or a line of text should change. Batch is the whole-image path for several files at once.</p>'),
		),
		'opposite' => array(
			'text' => 'This page adds blur. If the photo is already soft and you want it clearer, switch tools.',
			'path' => 'unblur-image',
			'label' => 'Unblur image',
		),
		'related' => array(
			array('path' => 'blur-image/background', 'label' => 'Blur background of photo'),
			array('path' => 'blur-image/face', 'label' => 'Blur face in photo'),
			array('path' => 'blog/how-to-make-picture-blurry', 'label' => 'How to make a picture blurry online'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
		),
	),
	array(
		'group' => 'blur',
		'slug' => 'background',
		'path' => 'blur-image/background',
		'faq_heading' => 'FAQ',
		'title' => 'Blur Background of Photo Online | Blur Image Background',
		'description' => 'Blur background of photo online. Blur picture background, add blur the image background for portrait photos.',
		'h1' => 'Blur Background of Photo Online | Blur Image Background',
		'lead' => '<p>Blur background of photo when the subject is fine and the room behind them is not. A blur image background edit keeps a person, or the main object in front, readable while the street, office, or backdrop falls out of focus. Hair, fur, writing, and shapes that blend in can be missed. Paint those parts. The photo stays on your device.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'background',
			'subject' => TRUE,
			'note_below' => TRUE,
			'note' => 'Objects keeps the main subject, such as a product, and blurs the backdrop. People and animals means a person or a common animal. Writing, logos, and edges that blend in are often missed. Paint those. Feather softens the edge.',
		),
		'sections' => array(
			array(
				'h2' => 'Why blur background in a photo',
				'html' => '<p>You blur background in a photo to cut distractions: a messy desk, other people, or a bright sign. It is a framing choice. It is not a way to hide the main subject.</p>',
			),
			array(
				'h2' => 'How to blur picture background step-by-step',
				'html' => '<ol><li>Add the portrait or product shot. Choose People and animals, or Objects.</li><li>Click Blur background. The first time, this tab downloads the finder, then softens the rest of the photo.</li><li>Paint anything the finder got wrong. Raise Feather if the edge looks sliced, then download.</li></ol><p>That is the practical way to blur picture background without a desktop suite. Expect a rough outline, not a studio cutout.</p>',
			),
			array(
				'h2' => 'Tips for background picture blur',
				'html' => '<p>People and animals means a person, bird, cat, dog, horse, cow, or sheep. Objects keeps the main thing in front, such as a bottle or a product, and blurs the backdrop. It can miss writing, logos, and parts that match the background. Paint those. Edges stay coarse. A huge Strength on a hard edge still looks like a cutout.</p>',
			),
			array(
				'h2' => 'How to edit blur background pics',
				'html' => '<p>Edit blur background pics by running Blur background on each shot, then matching Strength and Feather. Paint anything the finder missed. Turn Invert off only when you would rather mark the backdrop itself.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'How do I blur the image background for portrait photos?', 'a' => '<p>Choose People and animals, then Blur background. The room softens. The outline is coarse and hair can look cut out, so paint the missed parts and raise Feather. The photo is not uploaded. The first click for a choice downloads that finder; later clicks reuse it.</p>'),
			array('q' => 'Can I adjust blur strength for background picture blur?', 'a' => '<p>Yes. The slider is live. Stronger background picture blur hides more clutter and also looks less like a camera lens, so stop when the subject still feels attached to the scene.</p>'),
			array('q' => 'Does blurring background pics reduce photo quality?', 'a' => '<p>The background loses detail on purpose. With Invert on, the painted subject is copied from the original. Export is PNG, so you are not adding a second round of JPEG damage on top of the blur.</p>'),
		),
		'opposite' => array(
			'text' => 'Background blur adds softness. It will not repair a portrait that is already out of focus.',
			'path' => 'unblur-image/photos',
			'label' => 'Fix blurry photos',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur image'),
			array('path' => 'blur-image/effect', 'label' => 'Gaussian blur effect'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
			array('name' => 'Background', 'path' => 'blur-image/background'),
		),
	),
	array(
		'group' => 'blur',
		'slug' => 'face',
		'path' => 'blur-image/face',
		'faq_heading' => 'FAQ',
		'title' => 'Blur Face in Photo Online – Pixelate or Blur Faces',
		'description' => 'Blur face in photo online. Blur a face in a picture to protect privacy, apply photo blur face in one click.',
		'h1' => 'Blur Face in Photo Online – Pixelate or Blur Faces',
		'lead' => '<p>Blur face in photo before you post a street shot, a classroom, or a picture of a minor. The finder marks each face and widens the box past the eyes and chin. Remove a wrong box, or paint a face it missed. The photo stays on your device.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'face',
			'face' => TRUE,
			'note_below' => TRUE,
			'note' => 'Each found face is widened past the eyes and chin. Click a box to remove a wrong one. Paint any face the finder missed. Pixel blocks the features. Gaussian softens them. Black bar covers the box in solid black.',
		),
		'sections' => array(
			array(
				'h2' => 'When you need to blur face in photo',
				'html' => '<p>Blur face in photo for bystanders, patients, students, or anyone who did not agree to be identified. Badges and name tags next to the face belong in the same pass. If the sensitive part is a document instead of a person, use <a href="{{path:blur-image/text}}">blur text image</a>.</p>',
			),
			array(
				'h2' => 'How to blur a face in a picture',
				'html' => '<p>Add the photo, then click Blur faces. The first time, this tab downloads the finder. Each box is already wider than the eyes and chin, so hair and ears are inside the cover. Click a box to drop a miss. Paint any face that was skipped. Pixel is the privacy default. Gaussian is a soft cover. Black bar fills the box with solid black, so Strength does not apply.</p>',
			),
			array(
				'h2' => 'Pixelate vs soft blur for photo blur face',
				'html' => '<p>Pixel breaks the features into blocks and is the default for privacy. A light Gaussian can still look like the person. Black bar hides the widened box completely. Use it when the face must not be recognizable at all.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'Can I blur multiple faces in one photo?', 'a' => '<p>Yes. Blur faces marks every face it finds. Click a box to remove one that is wrong. Paint anyone the finder skipped, including a person in the back row. A crowd shot is not private if one person stays sharp. The photo is not uploaded. The first click downloads the finder; later clicks reuse it.</p>'),
			array('q' => 'Will blur face in photo permanently change my original file?', 'a' => '<p>No. Blur face in photo here builds a new PNG in the browser. Your camera file stays where it was unless you overwrite it yourself later.</p>'),
		),
		'opposite' => array(
			'text' => 'Face blur hides identity. It cannot recover a face that the camera already smeared.',
			'path' => 'unblur-image',
			'label' => 'Unblur image',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur image'),
			array('path' => 'blog/how-to-blur-face-in-photo', 'label' => 'How to blur face in photo for privacy'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
			array('name' => 'Face', 'path' => 'blur-image/face'),
		),
	),
	array(
		'group' => 'blur',
		'slug' => 'text',
		'path' => 'blur-image/text',
		'faq_heading' => 'FAQ',
		'title' => 'Blur Text Image Online | Blur Writing in Photo',
		'description' => 'Blur text image easily. Blur writing in photo to hide sensitive text information from pictures.',
		'h1' => 'Blur Text Image Online | Blur Writing in Photo',
		'lead' => '<p>Blur text image content when a picture shows an address, account number, medical note, or private message. The finder marks the writing. Remove a wrong box, or mark anything it missed. The photo stays on your device.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'text',
			'text' => TRUE,
			'note_below' => TRUE,
			'note' => 'Auto Blur All Text covers every line it can read, including Chinese and English. Blur Sensitive Only covers emails, phone numbers, and long numbers such as a card or an ID. Click a red box to remove it. Handwriting and very faint, widely spaced letters are often missed. Drag a rectangle or paint those.',
		),
		'sections' => array(
			array(
				'h2' => 'Use cases to blur text image',
				'html' => '<p>Typical blur text image jobs: a shipping label in an unboxing photo, a whiteboard in a meeting photo, a username in a screenshot, or a document on a desk. If a face is also visible, blur that on the <a href="{{path:blur-image/face}}">face page</a> in the same sitting.</p>',
			),
			array(
				'h2' => 'How to blur writing in photo online',
				'html' => '<p>Add the photo, then click Auto Blur All Text or Blur Sensitive Only. The first time, this tab downloads the finder. Each box is already wider than the letters. Click a red box to drop a miss. Drag a rectangle or paint handwriting and anything skipped. Redact fills the box with black or gray, and Strength does not apply. Pixel blocks the letters. Blur softens them.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'Can I selectively blur partial text on an image?', 'a' => '<p>Yes. Blur Sensitive Only covers emails, phone numbers, and long numbers, and leaves other writing sharp. Click a red box to remove one line. Drag a rectangle or paint a phrase the finder skipped.</p>'),
			array('q' => 'Is blur text image function free?', 'a' => '<p>Yes. The blur text image control is part of the same free browser editor. No account is required. The photo is not uploaded. The first click downloads the finder; later clicks reuse it.</p>'),
		),
		'opposite' => array(
			'text' => 'This tool covers writing. It will not make blurry text sharp again.',
			'path' => 'unblur-image',
			'label' => 'Unblur image',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur image'),
			array('path' => 'blog/how-to-blur-writing-in-photo', 'label' => 'How to blur writing in photo'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
			array('name' => 'Text', 'path' => 'blur-image/text'),
		),
	),
	array(
		'group' => 'blur',
		'slug' => 'online',
		'path' => 'blur-image/online',
		'faq_heading' => 'FAQ',
		'title' => 'Blur Image Online Free – No Software Installation',
		'description' => 'Use blur image online tool without app. Blur picture online, blur pic online directly inside browser.',
		'h1' => 'Blur Image Online Free – No Software Installation',
		'lead' => '<p>Blur image online in the browser you already have. The file is not uploaded. Blur picture online and blur pic online from a laptop or a phone, then save a PNG of the working copy.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'online',
			'note' => 'Works in the browser you already have. Close the tab when you are done and the picture leaves memory.',
		),
		'sections' => array(
			array(
				'h2' => 'Benefits of blur image online editor',
				'html' => '<p>A blur image online editor on this site skips installers and accounts. Pixels are processed in the tab, then discarded when you close it. There is no saved library. Background, face, and text steps stay on the <a href="{{path:blur-image}}">main blur image page</a> so this page can stay about the browser limits.</p>',
			),
			array(
				'h2' => 'How to use blur picture online',
				'html' => '<p>To blur picture online, drop the file, choose Gaussian or Pixel, and raise Strength. Strength opens at 0, so the photo stays unchanged until you move it. Brush limits the change to one region. Whole image softens the full frame.</p>',
			),
			array(
				'h2' => 'Supported formats for blur pic online',
				'html' => '<p>Blur pic online accepts JPG, PNG, and WEBP. If the long edge is above 1600 pixels, the editor scales the working copy down before you paint. The download is a PNG of that working copy, not a re-save of the camera original at full size.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'Do I need account for blur image online service?', 'a' => '<p>No. The blur image online editor does not ask you to sign in. There is no library of your past uploads because the file never leaves the device.</p>'),
			array('q' => 'What file size limit for blur picture online?', 'a' => '<p>There is no server quota. The practical limit is what your browser can hold in memory. Photos are reduced if the long edge is above 1600 pixels so blur picture online stays usable on a phone.</p>'),
		),
		'opposite' => array(
			'text' => 'Online blur adds a blur effect. To sharpen a blurry photo in the browser, use the other tool.',
			'path' => 'unblur-image',
			'label' => 'Fix blurry photos',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur picture'),
			array('path' => 'blog/how-to-make-picture-blurry', 'label' => 'How to make a picture blurry online'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
			array('name' => 'Online', 'path' => 'blur-image/online'),
		),
	),
	array(
		'group' => 'blur',
		'slug' => 'effect',
		'path' => 'blur-image/effect',
		'faq_heading' => 'FAQ',
		'title' => 'Blur Effect Image Online – Gaussian, Pixelate & Motion Effects',
		'description' => 'Apply photo-style blur effects instantly. Choose from Gaussian, Pixelate, Motion, and Radial blurs. Adjust strength and apply to the whole image or specific areas.',
		'h1' => 'Blur Effect Image Online – Gaussian, Pixelate & Motion Effects',
		'lead' => '<p>Apply photo-style blur effects instantly. Choose from Gaussian, Pixelate, Motion, and Radial blurs. Adjust strength and apply to the whole image or specific areas.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'effect',
			'effects' => TRUE,
			'note' => 'Whole image is selected. Motion adds Speed and Angle. Radial uses Blur Radius and a center you can drag. Pixel uses block size.',
		),
		'sections' => array(
			array(
				'h2' => 'Gaussian blur for photos',
				'html' => '<p>Gaussian blur for photos is the smooth soften people expect from a lens or a portrait mode. Use a low value for a blurry photo effect that still shows the scene. Use a high value when the frame should become a color field. Read the <a href="{{path:blog/gaussian-blur-guide}}">gaussian blur guide</a> if you want the reasoning before you slide.</p>',
			),
			array(
				'h2' => 'Pixelate blur effect',
				'html' => '<p>Pixelate blur replaces detail with flat blocks. It is the right blur effect on pictures when a face, plate, or line of type must not be reconstructed by looking harder. A light pixelate reads as a style. A heavy one reads as a mask.</p>',
			),
			array(
				'h2' => 'Fade images are not offered here',
				'html' => '<p>Fade images wash a photo toward a pale color so contrast falls. That is a color treatment, not a blur, and this editor does not do it. For a streak, choose Motion and set the angle. For a burst from one spot, choose Radial and drag the center. Gaussian softens. Pixel replaces detail with blocks.</p>',
			),
			array(
				'h2' => 'Apply blurry effects on pictures & photos',
				'html' => '<p>Pick one blurry effect. Gaussian is enough when the photo should still hint at the scene. Pixel is the one when a face or a line of type must stay unreadable. Motion, Radial, Noise, and Color are the other looks. Switch effects instead of stacking them. Whole image covers the frame. Brush, Marquee, and Lasso keep the change inside a region.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'What is difference between gaussian blur and pixelate blur?', 'a' => '<p>Gaussian blur melts edges into neighboring colors. Pixelate blur builds visible squares. Use gaussian blur for a soft portrait look and pixelate blur when someone must not be identified.</p>'),
			array('q' => 'Can I combine multiple blurry effects in one picture?', 'a' => '<p>No. Gaussian, Pixel, Noise, Motion, Radial, and Color are alternatives. Choose one and apply it to the whole image or to a region. Switching effects replaces the previous look.</p>'),
			array('q' => 'How to create fade images for social media?', 'a' => '<p>This editor does not create fade images. For a teaser, choose Gaussian, leave Apply to on Whole image, and raise Strength until the subject is hard to recognize. Download the PNG.</p>'),
		),
		'opposite' => array(
			'text' => 'These effects add softness. They are the wrong control if you are trying to clear a blurry photo.',
			'path' => 'unblur-image',
			'label' => 'Unblur image',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur effect on photos'),
			array('path' => 'blog/gaussian-blur-guide', 'label' => 'Gaussian blur complete guide'),
		),
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Blur Image', 'path' => 'blur-image'),
			array('name' => 'Effects', 'path' => 'blur-image/effect'),
		),
	),
);
