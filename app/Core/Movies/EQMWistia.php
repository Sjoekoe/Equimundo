<?php
namespace EQM\Core\Movies;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EQMWistia
{
    const WISTIA_BASE_URL = "https://api.wistia.com/v1/";
    const WISTIA_UPLOAD_URL = "https://upload.wistia.com";

    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var string
     */
    protected $format = 'json';

    public function __construct($apiKey = '')
    {
        $this->apiKey = $apiKey;
    }

    public function createProject(array $projectData)
    {
        $client = new Client();
        $res = $client->request('POST', self::WISTIA_BASE_URL . 'projects.json?api_password=' . $this->apiKey, [
            'name' => $projectData['name'],
        ]);

        return json_decode($res->getBody()->getContents());
    }

    public function uploadVideo(UploadedFile $file, $projectId)
    {
        $result = exec('curl -i -F api_password=' . $this->apiKey . ' -F project_id=' . $projectId . ' -F file=@' . $file . ' ' . self::WISTIA_UPLOAD_URL);

        return json_decode($result);
    }
}
