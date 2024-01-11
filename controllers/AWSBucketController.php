<?php
 
	require 'controllers/awss3bucket/aws-autoloader.php';
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;


class AWSBucket{

	protected $s3;
	protected $bucketName = 'esubhalekha';
	protected $IAM_KEY = 'AKIA4X3FUWUEORJBSKUT';
	protected $IAM_SECRET = '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';
	protected $objects="";

	 public function __construct()
    {     

    
        	// Connect to AWS
			try {
				$this->s3 = S3Client::factory(
					array(
						'credentials' => array(
							'key' => $this->IAM_KEY,
							'secret' => $this->IAM_SECRET
						),
						'version' => 'latest',
						'region'  => 'ap-south-1',
						'use_accelerate_endpoint' => true,
					)
				);

				$this->objects= $this->s3->listObjects([
					'Bucket'=>$this->bucketName
				]);
				
			} catch (Exception $e) {
				
			die("Error: " . $e->getMessage());
			}
    }

	
	function uploadToAWS($filearr,$filename){

		// For this, I would generate a unqiue random string for the key name. But you can do whatever.
		$keyName = 'test_example/'.time() . basename($filearr[$filename]['name']);  
		$pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $this->bucketName . '/' . $keyName;

		// Add it to S3
		try {
			
			if (!file_exists('/tmp/tmpfile')) {
				mkdir('/tmp/tmpfile',0777,true);
			}
				
			$tempFilePath = '/tmp/tmpfile/' . basename($filearr[$filename]['name']);
		 
			$tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");

			$fileContents = file_get_contents($filearr[$filename]['tmp_name']);
			$tempFile = file_put_contents($tempFilePath, $fileContents);

			$result =$this->s3->putObject(
				array(
					'Bucket'=>$this->bucketName,
					'Key' =>  $keyName,
					'SourceFile' => $tempFilePath,
					'StorageClass' => 'REDUCED_REDUNDANCY',
					'ACL'   => 'public-read'
				)
			);

			// Get the URL of the uploaded file
	        $uploadedFileUrl = $result['ObjectURL'];

	        return [
	                'error' => false,
	                'url' => $uploadedFileUrl
	            ];
	            

		} catch (S3Exception $e) {
			return [
	                'error' => true,
	                'errorMsg' => $e->getMessage()
	            ];
		} catch (Exception $e) {
			return [
	                'error' => true,
	                'errorMsg' => $e->getMessage()
	            ];
		}

	}

	function deleteFromAWS($imgurl){

		 if(is_null($this->objects)==0){
    		$files = $this->objects->getPath('Contents');
    		if(is_null($files)==0){
       
    			foreach ($files as $data) {  

    					if($this->s3->getObjectUrl($this->bucketName,$data['Key']) == $imgurl){

    						try{

								$result = $this->s3->deleteObject(array(
					        		'Bucket' => $this->bucketName,
					        		'Key'    => $data['Key']
					    		));


					            return [
					                'error' => false
					            ];

							}
							catch (S3Exception $e) {
								return [
					                 'error' => true,
					                 'errorMsg' => $e->getMessage()
					            ];
							} catch (Exception $e) {
								return [
						            'error' => true,
						            'errorMsg' => $e->getMessage()
						        ];
							}

    					}

   				 }
			}
		}
	
	}

}
	
?>
