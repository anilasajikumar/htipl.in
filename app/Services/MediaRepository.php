<?php
namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use App\Models\Media;
use App\Services\Files\FileStorage;
use App\Traits\CommonServiceTrait;

class MediaRepository {
  use CommonServiceTrait;
    private $model;
    private $fileStorage;

    public function __construct(
        Media $media,
        FileStorage $fileStorage
    ) {
        $this->model = $media;
        $this->fileStorage = $fileStorage;
    }

    /**
     * Create / Update Media
     */
    function saveMedia($course_media_id, $title, $file, $id = null){

        $data = [
            'course_media_id' => $course_media_id,
            'title' => $title,
            'file_name' => $file['file_name'],
            'file_path' => $file['full_path'],
            'mime_type' => strtolower($file['mime_type']),
            'extension' => strtolower($file['extension']),
            'type' => strtolower($file['type']),
            'thumbnail' => isset($file['thumbnail']) ? $file['thumbnail'] : '' ,
            'size' => $file['size'],
        ];
        return $this->create($data);

    }

    /**
     * Cr
     */

    function saveFile(UploadedFile $file , $course_media_id ='' , $title =''){
        $fileData = $this->uploadFile($file);
         return response()->json($fileData);
    }

    
    /**
     * Saves the file
     * @param UploadedFile $file
     * @return array
     */
    public function uploadFile(UploadedFile $file, $folder = 'upload')
    {
        $fileData = $this->fileStorage->uploadedFileToArray($file);
        
        $fileName = $fileData['file_name'];
        // // Group files by mime type
        $mime = str_replace('/', '-', $fileData['mime_type']);
        // // Group files by the date (week
        $dateFolder = date("Y-m-W");
        // // Build the file path
        $filePath = "{$folder}/{$mime}/{$dateFolder}/";
        // $finalPath = storage_path("app/".$filePath);
        // // move the file name
        // $file->move($finalPath, $fileName);

        $fileData['file_name'] = $this->fileStorage->put($file,$filePath,$fileName);
        $fileData['file_path'] =  $filePath;
        $fileData['full_path'] =  $filePath . $fileName;


        unset($fileData['contents']);

        return $fileData;

    }

}