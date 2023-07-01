<?php
// Check if the file was uploaded without any errors
if ($_FILES['image']['error'] === 0) {
  // Get the uploaded image details
  $image = $_FILES['image']['tmp_name'];
  $imageName = $_FILES['image']['name'];

  // Define the directory where the images will be stored
  $targetDir = 'images/';
  
  // Move the uploaded image to the target directory
  if (move_uploaded_file($image, $targetDir . $imageName)) {
    // Create or read the images.json file
    $imagesFile = fopen('images.json', 'a+');
    $images = [];

    // Read the existing images, if any
    $imagesData = fread($imagesFile, filesize('images.json'));
    if (!empty($imagesData)) {
      $images = json_decode($imagesData, true);
    }

    // Add the new image to the images array
    $images['images'][] = $targetDir . $imageName;

    // Write the updated images array back to images.json
    fwrite($imagesFile, json_encode($images));

    // Close the file
    fclose($imagesFile);
  }
}
