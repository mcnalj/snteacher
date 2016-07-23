<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  $question_id = $_SESSION["QuestionID"]; //need to load this up in new_question.php
  $quiz_name = $_SESSION["quiz_name"]; //need to load this up in new_question.php
  $image_file = $_POST["image_file"]; //look this up, it's complicated
  $title = mysql_prep($_POST["title"]);	
  $alt = mysql_prep($_POST["alt"]);
  $width = mysql_prep($_POST["width"]);
  $height = mysql_prep($_POST["height"]);
  $source_link = mysql_prep($_POST["source_link"]);
$author = mysql_prep($_POST["author"]);
$author_link = mysql_prep($_POST["author_link"]);
$license = mysql_prep($_POST["license"]);
$license_link = mysql_prep($_POST["license_link"]);
$html_code = mysql_prep($_POST["html_code"]);
$public_domain = mysql_prep($_POST["public_domain"]);    


	$query  = "INSERT INTO images (";
    $query .= " question_id, quiz_name, image_file, title, alt, width, height, source_link, author, author_link, license, license_link, html_code, public_domain ";
    $query .= ") VALUES (";
    $query .= " '{$question_id}', '{$quiz_name}', '{$image_file}', '{$title}', '{$alt}', '{$width}', '{$height}', '{$source_link}', '{$author}', '{$author_link}', '{$license}', '{$license_link}', '{$html_code}', '{$public_domain}' ";
    $query .= ")";


    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Image successfully added!";
	  redirect_to("image_file.php");
    } else {
      // Failure
	  die("Sorry, Atomic Teacher is a bit confused. Please try again later." . mysqli_error($connection));
    }
  }

?>
<?php include("../includes/layouts/teacher_header.php"); ?>

<body>
		
	<header>
		<div id = "banner">
			<img src="images/globeglass.png" alt="globe icon">
			<p id ="nameLogo">Atomic Teacher</p>		
		</div>

		<div id = "nav">
			<p id ="back"><a href="../index.php">Atomic Teacher Home</a></p>
			<p id ="logout"><a href="logout.php">Goodbye!</a></p>
		</div>
	</header>
	
		<aside id ="playerStatus">
		
			<div id="score">
				<p><a href="teacher_base.php">Back to Teacher Base</a></p>
			</div>
			
		</aside>

	
	<main>
		<article id="quizSpace">
				<h2>Insert Image</h2>
				<br />
				<p><?php echo $_SESSION["message"]; ?></p>
				<p>Question ID: <?php echo $_SESSION["QuestionID"]; ?></p>
				<p>Quiz Name: <?php echo $_SESSION["quiz_name"];?></p>
				<br />
				<p>Add image information or go back to <a href="new_question.php">Create Question</a>.</p>
				<br />
				<form action="insert_image.php" method="post">
					<fieldset>
					<div>
					<p>Where do you want to add this image?<p>
						<p>
						<select name="question_bank">
							<option value = "images">World Geography</option>
							<option value = 6>Some crazy ass quiz Croft is making</option>
							<option value = 7>New Quiz</option>
						</select>
					</p>
				</div>
				<br />
					<p>Question ID: (This needs to be the same as the question with which the images is associated.)
						<input type="text" name="question_id" value="<?php echo $_SESSION["QuestionID"]; ?>" />
					</p>
					<br />
					<p>Quiz Name: (This is also the same as the question with which this image is associated.)
					<br />
						<input type="text" name="quiz_name" value="<?php echo $_SESSION["quiz_name"]; ?>" />
					</p>
					<br />
					
			<!--	<div>
					<p>Quiz Name: (This is also the same as the quesion with which this image is associated.)</p>
					<p>
						<select name=quiz_name>
							<option value="World Geography">World Geography</option>
							<option value="constitution">The Constitution</option>
							<option value="miscellaneous">none</option>
						</select>
					</p>
					</div> -->
				
					<br />
					<p>Image File: (This is the file where Atomic Teacher will find the image. It should follow the convention of all lowercase with a "_" between words. JPG files are the best. Example: like_this.jpg) COMING SOON
					<input type="text" name="image_file" value="" />
					</p>
					<br />
					<p>Image Title: (This will be displayed beneath the image as part of the image credit. Make sure it doesn't give away the answer to the question.)</p>
					<textarea name="title" rows=1 cols=40></textarea>
					</p>
					<br />
					<p>Alternative Text: (This is a description of the image that will display while the file is loading and will be used to present the image to users employing assistive technologies.)</p>
					<textarea name="alt" rows=3 cols=40></textarea>
					<br />
					<br />
					<p>Indicate the actual width and height of the image in the Image File in pixels. Atomic Teacher will use these numbers to figure out the best way to fit the image into the 700px x 350px image display area.
					<p>Image Width:
						<input type="text" name="width" value="" />
					</p>
					<p>Image Height:
						<input type="text" name="height" value="" />
					</p>
					<br />
					<br />
					<p>The following input fields are related to the source of the image. Always make sure you have the rights to use the image and that you give the creator of the image credit for their creation.
					<p>Source Link: (This creates a link to where the image can be found on-line.)</p>
						<textarea name="source_link" rows=3 cols=40></textarea>
					<br />
					<p>Author:</p>
						<textarea name="author" rows=3 cols=40></textarea>
					<br />
					<p>Author Link: (This hyperlinks the author's name to the author's page.)</p>
						<textarea name="author.link" rows=3 cols=40></textarea>
					<br />
					<p>License:</p>
						<textarea name="license" rows=3 cols=40></textarea>
					<br />
					<p>License Link:</p>
						<textarea name="license_link" rows=3 cols=40></textarea>
					<br />
					<p>HTML Code: (If the image has a "Use this file on the web" button, copy the html provided and Atomic Teacher will use this to connect to the image rather than using the "image file.") USE THIS INSTEAD OF "Image File"</p>
						<textarea name="html_code" rows=3 cols=40></textarea>
					<br />
					<p>If the image is in the public domain, check this box and skip the license information. Atomic Teacher will generate the appropriate caption.</p>
					<br />
					<input type="hidden" name="public_domain" value=0 />
					<input type="checkbox" name="public_domain" value=1 />Public Domain
					<br />						
					<br />
					<input type="submit" name="submit" value="Submit Image Information" />
				</fieldset>
				</form>		
			</article>
		</main>
						

<?php include("../includes/layouts/footer.php"); ?>
			
					
			