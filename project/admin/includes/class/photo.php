<?php



class Photo {

    public int $id;
    public string $title;
    public string $alt;
    public string $path;
    public string $fileName;
    public string $type;
    private string $tmpPath;
    private string $uploadDir = ROOT_DIRECTORY.DIRECTORY_SEPARATOR.'images';
    private array $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );


    public function __construct() {
        $this->createDir();
    }

    public function setFile($file) {

        if (empty($file) || !$file) {
            // Display error
            echo 'Error';
        } else {
            $this->fileName = basename($file['name']);
            $this->tmpPath = $file['tmp_name'];
            $this->type = $file['type'];
        }
    }



    private function createDir() {
        if(!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir);
        }
    }
}