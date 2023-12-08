<?php

class Gallery extends Trongate implements JsonSerializable
{
    private const FILENAME = 'test';

    // allowed image extensions
    private array $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Properties of gallery images from the json file
    private array $gallery_images;

    // to store the image path of uploaded image
    private string $image_path;

    // to store image title (used in image labels, and in alt attributes)
    private string $image_title;


    private array $error_stack;

	private string $template_to_use = 'clean';


    // getters
    public function get_image_path(): string
    {
        return $this->image_path;
    }

    public function get_image_title(): string
    {
        return $this->image_title;
    }


    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->image_path = "";
        $this->image_title = "";

        $this->error_stack = [];
        $this->gallery_images = [];

        // Utility and validate modules ("A" children)
        $this->module('a-utility');
        $this->module('a-validate');
    }


    // form view to submit a new image with a title to the gallery
    function form()
    {
        $data['view_file'] = 'form';
        $data['error_stack'] = $this->error_stack;
        $data['form_location'] = str_replace('/form', '/submit', current_url());
        $this->template($this->template_to_use, $data);
    }

    // gallery view
    function gallery()
    {
        // get image properties from the json file
        $this->gallery_images = $this->_read_image_data_from_file();

        if (array_key_exists('error', $this->gallery_images)) {
            echo $this->gallery_images['error'];
        }

        // newer first order
        function order_by_date($a, $b, $property = 'upload_time')
        {
            return $b->{$property} - $a->{$property};
        }

        usort($this->gallery_images, 'order_by_date');

        $data['images'] = $this->gallery_images;
        $data['number_of_images'] = count($this->gallery_images);
        $data['view_file'] = 'gallery';

	    $data['title'] = 'Image gallery';
	    $data['description'] = 'A Very Simple Image Gallery';

        $this->template($this->template_to_use, $data);
    }

    public function submit() {
	    $this->module( 'trongate_security' );
	    $this->trongate_security->_make_sure_allowed();

        $has_error = $this->validate_image_form();
        if ($has_error === false) {
            // remove whitespace, strip tags
            $title = $this->validate->sanitize_text($_POST['title']);

            // temp file path
            $tmp_path = $_FILES['image']['tmp_name'];

            $gallery_folder_path = dirname(__FILE__, 2) .  '/assets/images/gallery/';

            // copy file to here
            $move_path = $gallery_folder_path . $_FILES['image']['name'];

            try {
                // perform file moving
                $success = @move_uploaded_file($tmp_path, $move_path);

                if ($success === false) {
                    throw new Exception('Failed to open stream: Engedély megtagadva');
                }
            } catch(Exception $e) {
                $this->error_stack[] = $e->getMessage();
                $this->validate->set_error('Unable to save the file.');
                $this->form();
            }


            $this->image_path = 'images/gallery/' . $_FILES['image']['name'];
            $this->image_title = $title;

            $this->_save_image_data_to_file();

            header('Location: ' . str_replace('/submit', '/gallery', current_url()));
//            $this->gallery();
        } else {
            $this->form();
        }
    }


    // read data from JSON
    private function _read_image_data_from_file(): array
    {
        // add extension to filename
        $filename = dirname(__FILE__, 2).'/assets/data/'.self::FILENAME.'.json';

        try {
            // check if file is empty
            if ($json = file_get_contents($filename, true)) {
                $data = json_decode($json);

            } else {
                throw new Exception('Error reading json file.');
            }
        } catch (Exception $e) {
            $this->error_stack[] = $e->getMessage();
            $this->validate->set_error($e->getMessage());
            return [];
        }

        return $data;
    }


    /**
     *  The json_encode function will not show private or protected properties.
     *  A JsonSerializable interface was added in PHP 5.4 which allows you to accomplish this.
     * @see https://www.codebyamir.com/blog/object-to-json-in-php
     */
    public function jsonSerialize(): array
    {
        return [
            'guid' => $this->utility->create_guid(),
            'image_path' => $this->get_image_path(),
            'image_title' => $this->get_image_title(),
            'upload_time' => $this->utility->create_timestamp(),
        ];
    }

    // save data to JSON file
    public function _save_image_data_to_file()
    {
        // add extension to filename
        $filename = dirname(__FILE__, 2).'/assets/data/'.self::FILENAME.'.json';

        // check if file is empty
        $emptyFile = !file_get_contents($filename);


        // read file if empty
        if ($emptyFile === true) {
            try {
                if (($result = fopen($filename, 'w')) === false) {
                    throw new Exception('Cannot write the JSON file because it is currently not accessible.');
                }
            } catch (Exception $e) {
                $this->error_stack[] = $e->getMessage();
                $this->validate->set_error($e->getMessage());
                $this->form();
            }

            // add first item to the file
            $json = "[";
            $json .= json_encode($this->jsonSerialize());
            $json .= "]";

            fwrite($result, $json);
            fclose($result);

            $success = 'OK. New image data saved.';
            set_flashdata($success);

            //--------------------------- File closed

        } // append file if not empty
        else {
            try {
                if (($result = fopen($filename, 'r')) === false) {
                    throw new Exception('Cannot read the JSON file because the file is inaccessible.');
                }
            } catch (Exception $e) {
                $this->error_stack[] = $e->getMessage();
                $this->validate->set_error($e->getMessage());
                $this->form();
            }

            $tmp = stream_get_contents($result);

            fclose($result);
            //--------------------------- File closed

            // remove ] from the end
            if(str_ends_with($tmp, ']')) {
                $tmp = substr($tmp, 0, (strlen($tmp) - 1));
            } else if(substr($tmp, -2, 1) == ']') {
                $tmp = substr($tmp, 0, (strlen($tmp) - 2));
            } else {
                $this->error_stack[] = 'Malformed json file. Check file endings ("]" in the last line)';
                $this->validate->set_error('Malformed json file. Check file endings ("]" in the last line)');
                $this->form();
                die;
            }


            // add , after previous item
            $tmp .= ", ";
            // append new item
            $tmp .= json_encode($this->jsonSerialize());
            // put ] back to the end
            $tmp .= "]";


            try {
                // we are not appending, overwriting the file!
                if (($result = fopen($filename, 'w')) === false) {
                    throw new Exception('Error. Cannot write to the JSON file.');
                }
            } catch (Exception $e) {
                $this->error_stack[] = $e->getMessage();
                $this->validate->set_error($e->getMessage());

                $this->form();
                die;
            }

            fwrite($result, $tmp);
            fclose($result);

            $success = 'OK. New image data saved.';
            set_flashdata($success);

            //--------------------------- File closed

        }

    }



    // validate user input
    private function validate_image_form(): bool
    {
        // validate in case of a post method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $has_error = false;


            // check file input
            if (isset($_FILES['image']) && !empty($_FILES['image'])) {

                $gallery_folder_path = dirname(__FILE__, 2) .  '/assets/images/gallery/';

                // POST image error
                if ($_FILES['image']['error'] > 0) {
                    $has_error = true;
                    $error_code = $_FILES['image']['error'];

                    /**
                     * Error code explanations
                     * @see https://www.php.net/manual/en/features.file-upload.errors.php
                     */
                    switch ($error_code) {
                        case 1:
                            $this->validate->set_error('The uploaded file exceeds the upload_max_filesize directive in php.ini.');
                            $this->error_stack[] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                            break;
                        case 2:
                            $this->validate->set_error('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.');
                            $this->error_stack[] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                            break;
                        case 3:
                            $this->validate->set_error('The uploaded file was only partially uploaded.');
                            $this->error_stack[] = 'The uploaded file was only partially uploaded.';
                            break;
                        case 4:
                            $this->validate->set_error('No file was uploaded.');
                            $this->error_stack[] = 'No file was uploaded.';
                            break;
                        case 6:
                            $this->validate->set_error('Missing a temporary folder.');
                            $this->error_stack[] = 'Missing a temporary folder.';
                            break;
                        case 7:
                            $this->validate->set_error('Failed to write file to disk.');
                            $this->error_stack[] = 'Failed to write file to disk.';
                            break;
                        case 8:
                            $this->validate->set_error('A PHP extension stopped the file upload.');
                            $this->error_stack[] = 'A PHP extension stopped the file upload.';
                            break;
                        default:
                            $this->validate->set_error('An unspecified PHP error occured.');
                            $this->error_stack[] = 'An unspecified PHP error occured.';
                            break;
                    }

                    $this->validate->set_error('Hiba a fájl feltöltésekor. Próbáld újra.');
                    $this->error_stack[] = 'Hiba a fájl feltöltésekor. Próbáld újra.';
                }

                // Check upload content to filter out some malicious code
                // read the header information of the image and will fail on an invalid image.
                if ($_FILES['image']['tmp_name'] && !@getimagesize($_FILES['image']['tmp_name'])) {
                    $has_error = true;
                    $this->validate->set_error('A feltöltött kép érvénytelen.');
                    $this->error_stack[] = 'A feltöltött kép érvénytelen.';
                }

                // check if filename contains illegal chars
                if ($this->validate->is_filename_valid($_FILES['image']['name'] === false)) {
                    $has_error = true;
                    $this->validate->set_error('Fájlnév nem tartalmazhat ékezetes betűket, speciális karaktereket (pl. $, [, { stb.)');
                    $this->error_stack[] = 'Fájlnév nem tartalmazhat ékezetes betűket, speciális karaktereket (pl. $, [, { stb.)';
                }

                // check if filename is not too long
                if ($this->validate->is_filename_too_long($_FILES['image']['name'] === true)) {
                    $has_error = true;
                    $this->validate->set_error('A fájlnév túl hosszú. Max. 250 karakter a megengedett hossz.');
                    $this->error_stack[] = 'A fájlnév túl hosszú. Max. 250 karakter a megengedett hossz.';
                }

                // max 500 KB!
                if ($_FILES['image']['size'] > 512000) {
                    $has_error = true;
                    $this->validate->set_error('A fájl mérete nem lehet nagyobb, mint 500 KB.');
                    $this->error_stack[] = 'A fájl mérete nem lehet nagyobb, mint 500 KB.';
                }

                // get image extension, note it will not stop malicious code embedded in the image
                $type = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


                if (!in_array($type, $this->allowed_extensions)) {
                    $has_error = true;
                    $this->validate->set_error('A fájlnév kiterjesztése csak JPG, JPEG, PNG vagy GIF lehet.');
                    $this->error_stack[] = 'A fájlnév kiterjesztése csak JPG, JPEG, PNG vagy GIF lehet.';
                }


                // split string to get filename without extension
                $exploded_filename = explode('.', $_FILES['image']['name']);

                // change uploaded filename datetime + random numbers + type
                $_FILES['image']['name'] = $exploded_filename[0].'-'.date('Ymdhis').random_int(6, 20).'.'.$type;


                // if file exists, stop moving file from temp to destination folder
                // there is a minimal chance of filename duplication, but unlikely after randomization
                if (file_exists($gallery_folder_path . $_FILES['image']['name'])) {
                    $has_error = true;
                    $this->validate->set_error('Ilyen nevű fájl már létezik. Próbáld újra feltölteni.');
                    $this->error_stack[] = 'Ilyen nevű fájl már létezik. Próbáld újra feltölteni.';
                }
            } else {
                $has_error = true;
                $this->validate->set_error('Nem adtál meg képet a feltöltéshez.');
                $this->error_stack[] = 'Nem adtál meg képet a feltöltéshez.';
            }


            // check title input
            if (empty($_POST['title'])) {
                $has_error = true;
                $this->validate->set_error('Nem adtál címet a képnek.');
                $this->error_stack[] = 'Nem adtál címet a képnek.';
            }


            return $has_error;
        }
        return false;
    }

}
