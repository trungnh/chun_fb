<?php 
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');

class Youtube
{
	private $_format = "video/mp4"; //the MIME type of the video. e.g. video/mp4, video/webm, etc.
	private $_info;
	
	public function setMIMEFormat($format)
	{
		$this->_format = $format;
	}
	
	public function getHQThumb($id)
	{
		return "http://img.youtube.com/vi/{$id}/hqdefault.jpg";
	}
	
	public function getHQThumbFile($id = "00")
	{
		//decode the data
		$info = $this->getVideoInfo($id);
		$title = $this->clean($info["title"]);
		$video_dir = __DIR__ . "/videos/";
		
		$url = "http://img.youtube.com/vi/{$id}/hqdefault.jpg";
		$img = $video_dir . $title . '.jpg';
		
		file_put_contents($img, file_get_contents($url));
		return $img;
	}
	
	public function getFileName($id)
	{
		//decode the data
		$info = $this->getVideoInfo($id);
		$title = $this->clean($info["title"]);
		$video_dir = __DIR__ . "/videos/";
		
		return $video_dir . "{$title}." . str_replace('video/','', $this->_format);
		
	}
	
	public function getVideoInfo($id)
	{
		if(!$this->_info)
		{
			//decode the data
			parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $id), $this->_info);
		}
		return $this->_info;
	}
	
	public function download($id)
	{
		$fileName = $this->getFileName($id);
		if(file_exists($fileName))
		{
			return $fileName; 
		}
		
		$info = $this->getVideoInfo($id);
		//the video's location info
		$streams = $info['url_encoded_fmt_stream_map'];
		
		$streams = explode(',' ,$streams);

		foreach($streams as $stream){
			parse_str($stream,$data); //decode the stream
			
			//We've found the right stream with the correct format
			if(stripos($data['type'],$this->_format) !== false){
				$sig = isset($data['sig']) ? $data['sig'] : "";
				$video = fopen($data['url'].'&amp;signature='.$sig,'r'); //the video
				
				$file = fopen($fileName,'w'); //create video file
				stream_copy_to_stream($video, $file); //copy it to the file
				fclose($video);
				fclose($file);
				return $fileName;
			}
		}
	}
	
	function clean($string) 
	{
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}
