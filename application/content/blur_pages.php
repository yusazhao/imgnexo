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
		'lead' => '<p>Blur a picture in your browser when part of the frame should be harder to read. Upload the image, soften the whole photo, or paint over a face, some text, or a busy background. Preview the result, then download a PNG. The original stays on your device.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'soft',
			'heading' => 'How to Blur an Image Online',
			'intro' => '<p>The photo stays in your browser. Choose Gaussian or Pixel, then download a PNG copy. The original file on your device is left alone.</p>',
			'note' => 'Gaussian softens the photo. Pixel hides faces and text. Use Brush when only part of the picture should change.',
			'steps' => array(
				'Upload a JPG, PNG, or WEBP, or load the sample.',
				'Pick Gaussian or Pixel and raise strength. Switch to Brush to paint one area.',
				'Hold “Hold for original” to compare, then download.',
			),
		),
		'sections' => array(
			array(
				'h2' => 'Blur Picture Background',
				'html' => '<p>A soft backdrop keeps a person or product easier to see. People look for blur background of photo, blur picture background, and blur image background when a busy street or room is stealing attention.</p><p>The dedicated walkthrough is on the <a href="{{path:blur-image/background}}">blur background of photo</a> page. Paint the backdrop instead of the subject if you only want that part softened.</p>',
				'children' => array(
					array(
						'h3' => 'Different Ways to Blur Photo Background',
						'html' => '<p>A wide gaussian blur looks like a shallow depth of field. Pixelate is harsher and better when the background contains a sign or a screen. Fade washes the backdrop toward a light tone if you want less texture, not just less sharpness.</p>',
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
				'html' => '<p>A blur effect on pictures can be a light soft-focus look or a heavy blur effect on photos. Blur effect image settings and other blurry effects are grouped on the <a href="{{path:blur-image/effect}}">blur effect</a> page, including gaussian blur, pixelate blur, and fade images.</p>',
			),
			array(
				'h2' => 'Make Picture Blurry',
				'html' => '<p>Make picture blurry when the whole frame should be hard to inspect: a teaser, a spoiler cover, or a placeholder. The same slider lets you make image blurry, make a pic blurry, or make images blurry in a series. This blurry image maker is also the blurry picture maker for a one-off edit.</p>',
			),
			array(
				'h2' => 'Online Blur Image Tool',
				'html' => '<p>You can blur image online, blur picture online, or blur pic online without installing software. Open the <a href="{{path:blur-image/online}}">browser editor</a>, drop the file, and download the result. Nothing is stored on a server.</p>',
			),
			array(
				'h2' => 'Image Blurring Tool & Photo Blur App',
				'html' => '<p>This image blurring tool works as a photo blur tool and a picture blur tool in the browser, so a separate blur image app or blurry pic app is optional. If you were looking for a blur photo editing app, start here and skip the install. This photo editor blur image flow adds blur. It does not repair a shot that is already soft.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'How do I blur out picture?', 'a' => '<p>Upload the file, raise the blur slider until the detail you care about disappears, and download the PNG. To blur out picture content in only one spot, turn on paint mode and stroke that area.</p>'),
			array('q' => 'How can I blur out photo?', 'a' => '<p>Open the editor, choose the photo, and blur out photo regions that show a face, a plate, or private writing. Hold the original button if you want to confirm you did not soften the wrong part.</p>'),
			array('q' => 'How to blur out image?', 'a' => '<p>To blur out image detail, use gaussian blur for a smooth cover or pixelate for blocks. Pixelate is harder to reverse by squinting at the file.</p>'),
			array('q' => 'What is gaussian blur?', 'a' => '<p>Gaussian blur averages nearby pixels with a bell-curve falloff, so edges melt instead of turning into squares. The blur slider on this page is that style of soften. A longer guide is in <a href="{{path:blog/gaussian-blur-guide}}">the gaussian blur article</a>.</p>'),
			array('q' => 'How to use pixelate blur on pictures?', 'a' => '<p>Set pixelate above 1. Larger blocks hide faces and text more reliably than a light soft blur. You can still add a little gaussian blur on top if the squares look too sharp.</p>'),
			array('q' => 'Can I blur image for WhatsApp?', 'a' => '<p>Yes. Edit first, download the PNG, then send that file in WhatsApp. Blurring inside this page does not connect to WhatsApp. A whatsapp blur image search usually means you want the censored file before you attach it to a chat.</p>'),
			array('q' => 'What does fade images effect do?', 'a' => '<p>Fade images lifts the picture toward a pale tone so contrast drops. It is a wash, not a privacy mask. Pair it with blur if you still need text or a face to be unreadable.</p>'),
			array('q' => 'Where can I get a blurry picture maker?', 'a' => '<p>This page is the blurry picture maker. Use the editor above, then download. You do not need a separate account.</p>'),
			array('q' => 'Is there a blurry image maker for quick edits?', 'a' => '<p>Yes. The blurry image maker above is meant for a short edit: upload, set the strength, download. For a face-only or text-only pass, switch on paint mode.</p>'),
			array('q' => 'What is the difference between blur pic and blur picture?', 'a' => '<p>Blur pic and blur picture are the same request. So are blur and image, blur for pictures, and the common misspelling blure picture. All of them mean you want the photograph softened or partly hidden, not sharpened.</p>'),
			array('q' => 'Can I apply blur for pictures without download app?', 'a' => '<p>Yes. Blur for pictures in this browser and download only the finished PNG. There is no app to install.</p>'),
			array('q' => 'How to put blur on image easily?', 'a' => '<p>To put blur on image, drop the file on the editor and move the blur slider. Paint mode is there when blur on image should cover only a license plate, a face, or a line of text.</p>'),
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
		'lead' => '<p>Blur background of photo when the subject is fine and the room behind them is not. A blur image background edit keeps the person readable while the street, office, or crowd falls out of focus.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'background',
			'note' => 'Turn on paint mode and stroke the backdrop. Leave the person or product unpainted so it stays sharp.',
		),
		'sections' => array(
			array(
				'h2' => 'Why blur background in a photo',
				'html' => '<p>You blur background in a photo to cut distractions: a messy desk, other people, or a bright sign. It is a framing choice. It is not a way to hide the main subject.</p>',
			),
			array(
				'h2' => 'How to blur picture background step-by-step',
				'html' => '<ol><li>Upload the portrait or product shot.</li><li>Keep paint mode on and brush over the area behind the subject.</li><li>Raise blur until the backdrop is soft, then download.</li></ol><p>That is the practical way to blur picture background without a desktop suite.</p>',
			),
			array(
				'h2' => 'Tips for background picture blur',
				'html' => '<p>For a convincing background picture blur, use a medium strength and overlap your strokes so you do not leave sharp islands. Feather the edge by using a slightly larger brush where the subject meets the room. A huge blur on a busy edge can look like a cutout.</p>',
			),
			array(
				'h2' => 'How to edit blur background pics',
				'html' => '<p>To edit blur background pics in a batch of similar shots, use the same strength each time so the set matches. Blur background pics of groups by painting only the distant layer. If a face is in that layer and should not be identifiable, switch to the <a href="{{path:blur-image/face}}">face blur</a> steps and pixelate it.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'How do I blur the image background for portrait photos?', 'a' => '<p>Paint around the person, then increase blur. Blur the image background more when the backdrop has text or a screen. Do not paint the face unless you also want that hidden.</p>'),
			array('q' => 'Can I adjust blur strength for background picture blur?', 'a' => '<p>Yes. The slider is live. Stronger background picture blur hides more clutter and also looks less like a camera lens, so stop when the subject still feels attached to the scene.</p>'),
			array('q' => 'Does blurring background pics reduce photo quality?', 'a' => '<p>The painted area loses detail on purpose. The unpainted subject is copied from the original. Export is PNG, so you are not adding a second round of JPEG damage on top of the blur.</p>'),
		),
		'opposite' => array(
			'text' => 'Background blur adds softness. It will not repair a portrait that is already out of focus.',
			'path' => 'unblur-image/photos',
			'label' => 'Fix blurry photos',
		),
		'related' => array(
			array('path' => 'blur-image', 'label' => 'Blur image'),
			array('path' => 'blur-image/effect', 'label' => 'Gaussian blur effect'),
			array('path' => 'blog/how-to-make-picture-blurry', 'label' => 'How to make a picture blurry online'),
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
		'lead' => '<p>Blur face in photo before you post a street shot, a classroom, or a picture of a minor. To blur a face in a picture, cover the whole head, not only the eyes. Photo blur face edits should remove identity, not just look artistic.</p>',
		'figure' => array(
			'src' => 'img/blur-face-in-photo-example.svg',
			'alt' => 'blur face in photo example',
			'caption' => 'A usable blur face in photo example covers the full head, including hairline and chin.',
		),
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'face',
			'note' => 'Paint each face, then keep pixelate high enough that eyes and teeth are not recognizable.',
		),
		'sections' => array(
			array(
				'h2' => 'When you need to blur face in photo',
				'html' => '<p>Blur face in photo for bystanders, patients, students, or anyone who did not agree to be identified. Badges and name tags next to the face belong in the same pass. If the sensitive part is a document instead of a person, use <a href="{{path:blur-image/text}}">blur text image</a>.</p>',
			),
			array(
				'h2' => 'How to blur a face in a picture',
				'html' => '<p>Upload the shot, leave paint mode on, and stroke from forehead to chin, ear to ear. Then blur a face in a picture with pixelate first. Add a little soft blur only if the block edges need to blend. Use the zoom control to check for a missed eye or ear.</p>',
			),
			array(
				'h2' => 'Pixelate vs soft blur for photo blur face',
				'html' => '<p>Soft photo blur face can still be recognizable at a low strength. Pixelate breaks the features into blocks and is the better default for privacy. Gaussian blur is fine for a stylistic portrait when you are allowed to show that person and only want a softer look.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'Can I blur multiple faces in one photo?', 'a' => '<p>Yes. Paint every face before you download. A crowd shot is not private if one person in the back row is still sharp.</p>'),
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
		'lead' => '<p>Blur text image content when a picture shows an address, account number, medical note, or private message. Blur writing in photo is safer than covering it with a thin mark someone can read around.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'text',
			'note' => 'Use a smaller brush and paint every character. Pixelate if the letters are still guessable.',
		),
		'sections' => array(
			array(
				'h2' => 'Use cases to blur text image',
				'html' => '<p>Typical blur text image jobs: a shipping label in an unboxing photo, a whiteboard in a meeting photo, a username in a screenshot, or a document on a desk. If a face is also visible, blur that on the <a href="{{path:blur-image/face}}">face page</a> in the same sitting.</p>',
			),
			array(
				'h2' => 'How to blur writing in photo online',
				'html' => '<p>To blur writing in photo, paint the full line, including ascenders and punctuation. A blur that only hits the center of a word often leaves enough shape to read it. Follow with pixelate when the type is large.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'Can I selectively blur partial text on an image?', 'a' => '<p>Yes. Paint only the private line and leave the rest of the picture sharp. Selectively covering one phrase is the usual blur writing in photo task.</p>'),
			array('q' => 'Is blur text image function free?', 'a' => '<p>Yes. The blur text image control is part of the same free browser editor. No account is required.</p>'),
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
		'lead' => '<p>Blur image online when you do not want another desktop program. Blur picture online and blur pic online from a laptop or a phone browser, then save the PNG.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'online',
			'note' => 'Works in the browser you already have. Close the tab when you are done and the picture leaves memory.',
		),
		'sections' => array(
			array(
				'h2' => 'Benefits of blur image online editor',
				'html' => '<p>A blur image online editor skips installers and accounts. The picture is not uploaded, which matters if the file contains a face or an address you are about to hide. You can still do background, face, and text edits from the <a href="{{path:blur-image}}">main blur image page</a>.</p>',
			),
			array(
				'h2' => 'How to use blur picture online',
				'html' => '<p>To blur picture online, drop the file, move blur or pixelate, and download. Paint mode limits the change to one region. If you only needed a stylistic soften, leave paint mode off and blur the full frame.</p>',
			),
			array(
				'h2' => 'Supported formats for blur pic online',
				'html' => '<p>Blur pic online accepts JPG, PNG, and WEBP in current browsers. Very large files are scaled down for the edit so the page stays responsive. The download is PNG.</p>',
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
		'title' => 'Blur Effect Image Online – Gaussian, Pixelate & Fade Effects',
		'description' => 'Apply blur effect image, gaussian blur, pixelate blur and fade images. Add blurry effects on photos and pictures.',
		'h1' => 'Blur Effect Image Online – Gaussian, Pixelate & Fade Effects',
		'lead' => '<p>Apply a blur effect image when you want a look, not only a censorship box. Gaussian blur, pixelate blur, and fade images can be used alone or together. These blurry effects sit on top of the original instead of trying to invent detail.</p>',
		'tool' => array(
			'mode' => 'blur',
			'preset' => 'effect',
			'note' => 'The sample starts with a light gaussian blur, visible pixel blocks, and a fade wash. Move each slider independently.',
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
				'h2' => 'Fade images soft transition effect',
				'html' => '<p>Fade images by washing the frame toward a pale paper tone. It lowers contrast so the shot feels faded rather than out of focus. It will not hide a secret by itself. Combine fade with blur if privacy is the goal.</p>',
			),
			array(
				'h2' => 'Apply blurry effects on pictures & photos',
				'html' => '<p>You can stack blurry effects: pixelate first, then gaussian blur, then a short fade. That combination is a common blur effect on photos for thumbnails and spoilers. A blur effect on pictures that only needs atmosphere can stop at a small gaussian blur. More region tools live on the <a href="{{path:blur-image}}">blur image</a> page.</p>',
			),
		),
		'faqs' => array(
			array('q' => 'What is difference between gaussian blur and pixelate blur?', 'a' => '<p>Gaussian blur melts edges into neighboring colors. Pixelate blur builds visible squares. Use gaussian blur for a soft portrait look and pixelate blur when someone must not be identified.</p>'),
			array('q' => 'Can I combine multiple blurry effects in one picture?', 'a' => '<p>Yes. The three sliders apply together. If the stack looks muddy, lower fade first, then blur, and leave pixelate only where you still need blocks.</p>'),
			array('q' => 'How to create fade images for social media?', 'a' => '<p>Raise fade until the highlights look dusty, keep blur low, and download the PNG. For a story cover that must hide the ending, add gaussian blur on top of that fade images treatment.</p>'),
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
