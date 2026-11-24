<?php namespace App\Services\Files;

use App\Models\Media;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;

class FileStorage {


    /**
     * Laravel Storage service instance.
     *
     * @var FilesystemAdapter
     */
    private $laravelStorage;

    /**
     * Storage constructor.
     *
     * @param Upload $upload
     * @param FilesystemManager $laravelStorage
     */
    public function __construct(FilesystemManager $laravelStorage)
    {
        $this->laravelStorage = $laravelStorage;
    }

    /**
     * Save specified files to currently active flysystem disk.
     *
     * @param mixed $contents
     * @param string $path
     * @param string $fileName
     * @param array $options
     *
     * @return string
     */
    public function put($contents, $path = 'uploads', $fileName = null, $options = [])
    {
        if ( ! $fileName) $fileName = md5(str_random(40).time());
        if ( ! $path) $path = 'uploads';

        $disk = Arr::pull($options, 'disk');

        if ($contents instanceof File || $contents instanceof UploadedFile) {
            $this->laravelStorage->disk($disk)->putFileAs($path, $contents, $fileName, $options);
        } else {
            $this->laravelStorage->disk($disk)->put($path.'/'.$fileName, $contents, $options);
        }

        return $fileName;
    }

    /**
     * Save static (inline) images in specified folder.
     *
     * @param UploadedFile|array $file
     * @param string $folder
     *
     * @return string
     */
    public function putStatic($file, $folder)
    {
        if (is_a($file, UploadedFile::class)) {
            $extension = $file->guessClientExtension();
        } else {
            $extension = $file['extension'];
            $file = $file['contents'];
        }

        $fileName = str_random(40) . '.' . $extension;

        $fileName = $this->put($file, "$folder-images", $fileName, ['visibility' => 'public', 'disk' => 'public']);

        return "storage/$folder-images/$fileName";
    }



      /**
     * Convert laravel|symfony UploadedFile instance into array.
     *
     * @param UploadedFile $fileData
     * @return array
     */
    public function uploadedFileToArray(UploadedFile $fileData)
    {
        return [
            'original_name' => $fileData->getClientOriginalName(),
            'file_name' => $this->createFilename($fileData),
            'mime_type' => $fileData->getMimeType(),
            'size' => $fileData->getClientSize(),
            'extension' => $fileData->getClientOriginalExtension(),
            'contents'  => $fileData,
            'type'  =>$this->getFileType($fileData->getClientOriginalExtension(),$fileData->getMimeType()),
        ];
    }

     /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension
        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;
        return $filename;
    }



    function getFileType($extension,$mime = null){
        $extension = strtolower( $extension );
        if(in_array($extension,['jpg','jpeg','png','gif','psd'])){
            return Media::IMAGE;
        }
        if(in_array($extension,['mp4','webm','mkv','3gp','mov'])){
            return Media::VIDEO;
        }
        if(in_array($extension,['pdf','doc','docx','txt','xlx'])){
            return Media::DOCUMENT;
        }
        if($mime){
            $mime = strtolower($mime);
            $mime = explode($mime,'/')[0];
            if(strpos($mime,'image') > 0){
                return Media::IMAGE;
            }
            if(strpos($mime,'video') > 0){
                return Media::VIDEO;
            }

            return Media::DOCUMENT;
        }
        

    }



}