<?php 

    class Download{

        CONST URL_MAX_LENGTH = 2024;

        /**
         * Clean URL
         */
        protected function cleanUrl($url){
            if(isset($url)){
                if(!empty($url)){
                    if(strlen($url) < self::URL_MAX_LENGTH){
                        return strip_tags($url);
                    }
                }
            }
        }

        /**
         * is URL
         */

         protected function isUrl($url){
            $url = $this->cleanUrl($url);

            if(isset($url)){
                if(filter_var($url, FILTER_VALIDATE, FILTER_FLAG_PATH_REQUIRED)){
                    return $url;
                }
            }
         }

         /**
          * return Extenstion
          */
        
          protected function returnExtension($url){
            if($this->isUrl($url)){
              $end = end(preg_split("/[.]+/", $url)); 
              if(isset($end)) {
                return $end;
              }
            }
          }

          /**
           * Download File
           */
        
          public function downloadFile($url){
            if($this->isUrl($url)){
                $extension = $this->returnExtension($url);

                if($extension){
                    ## PHP cURL
                    $ch = curl_init();
                    curl_setopt($ch,  CURLOPT_URL, $url);
                    $return = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $curl_exec($ch);
                    $curl_close($ch);

                    $destination = "./downloads/file.$extension";

                    $file = fopen($destination, "w+");
                    fputs($file, $return);
                    if(fclose($file)){
                        echo "File Downloaded!";
                    }
                }
            }
          }

    }

    $obj = new Download();

    // if(isset($_POST['url']){
    //     $url = $_POST['url'];
    // })

    if(isset($url)){
        $obj->downloadFile($url);
    }

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP cURL</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

    <h1 class="display-3 text-center text-primary py-4">PHP cURL Download Files</h1>

    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="POST">
                <input type="text" name="url" maxlength="2000" class="form-control" placeholder="Please Enter url">
                <input type="submit" value="Download" class="btn btn-primary btn-lg rounded-0 my-3">
            </form>
        </div>
      </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>


