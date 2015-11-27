<?php

/**
 * Usage:
 *      $image = new Libraries_Image();
 *
 *      $image->setImage('/upload/images/devices/7ALCX300E/7ALCX300E_img001.png')->createThumb('1200x600'); // create thumb
 *      $image_url = $image->setImage('/upload/images/gibson_portrait.jpg')->getThumb('1200x600'); // get thumb url
 *      $image_url = Libraries_Image::getThumbFromImage('/upload/images/gibson_portrait.jpg', '1200x600'); // get thumb url
 * @author vukasin
 *
 */
class Libraries_Image
{
	const THUMBMETHOD_FIT = 1;
	const THUMBMETHOD_CROP = 2;

	private $image_url = null;

	/**
	 *
	 * @param string $image_url
	 */
	public function __construct($image_url = '')
	{
		if(!empty($image_url))
		{
			$this->setImage($image_url);
		}
	}

	/**
	 * Set image
	 * @param string $image_url
	 * @return Libraries_Image
	 */
	public function setImage($image_url)
	{
		$this->image_url = $image_url;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getImage()
	{
		return $this->image_url;
	}

	public function getImageAbsolutePath()
	{
		return PROJECT_ROOT_DIR . '/' . $this->image_url;
	}

	/**
	 * Get thumb
	 * @param string$dimensions
	 * @param int $thumb_method
	 */
	public function getThumb($dimensions, $thumb_method = Libraries_Image::THUMBMETHOD_FIT)
	{
		$image_url = $this->getThumbName($dimensions);

		/*
		$this->createThumb($dimensions, $thumb_method);
		return $image_url;
		*/
		
		if(file_exists(PROJECT_ROOT_DIR . '/' . $image_url))
		{
			return $image_url;
		}
		else
		{
			$this->createThumb($dimensions, $thumb_method);
			return $image_url;
		}

		return ''; // some error
	}

	/**
	 *
	 * Create thumb image
	 * @param string $dimensions
	 * @param int $thumb_method
	 * @return Libraries_Image
	 */
	public function createThumb($dimensions, $thumb_method = Libraries_Image::THUMBMETHOD_FIT)
	{
		list($new_image_width, $new_image_height) = explode('x', $dimensions);

		$original_image_data = getimagesize($this->getImageAbsolutePath());
		$source_image_width = $original_image_data[0];
		$source_image_height = $original_image_data[1];
		$source_image_type = $original_image_data[2];
		$source_image_mime = $original_image_data['mime'];

		$new_image = imagecreatetruecolor($new_image_width, $new_image_height);
		imagealphablending($new_image, false);

		// set transparen color
		$background = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
		//$background = imagecolorallocate($new_image, 0, 0, 0);
		imagefilledrectangle($new_image, 0, 0, $new_image_width, $new_image_height, $background);

		// create original image resource
		if($source_image_type == IMAGETYPE_JPEG)
		{
			$original_image = imagecreatefromjpeg($this->getImageAbsolutePath());
		}
		elseif($source_image_type == IMAGETYPE_PNG)
		{
			$original_image = imagecreatefrompng($this->getImageAbsolutePath());
		}

		if($thumb_method == Libraries_Image::THUMBMETHOD_FIT)
		{
			$source_new_image_height = $new_image_height;
			$ratio = (100 * $new_image_height) / $source_image_height;

			$source_new_image_width = intval($source_image_width * $ratio / 100);

			if($source_new_image_width > $new_image_width)
			{
				$ratio = (100 * $new_image_width) / $source_new_image_width;
				$source_new_image_width = $new_image_width;

				$source_new_image_height = $source_new_image_height * $ratio / 100;
			}

			imagecopyresampled($new_image, $original_image, ($new_image_width - $source_new_image_width) / 2, ($new_image_height - $source_new_image_height) / 2, 0, 0, $source_new_image_width, $source_new_image_height, $source_image_width, $source_image_height);
			imagealphablending($new_image, true);
		}
		else if($thumb_method == Libraries_Image::THUMBMETHOD_CROP)
		{
			if (($new_image_width * $source_image_height) / $source_image_width < $new_image_height)
			{
				$source_image_ratio = ($new_image_width * $source_image_height) / $source_image_width / $new_image_height;
				$source_image_width = $source_image_ratio * $source_image_width;
			}
			else
			{
				$source_image_ratio = ($new_image_height * $source_image_width) / $source_image_height / $new_image_width;
				$source_image_height = $source_image_ratio * $source_image_height;
			}

			imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_image_width, $new_image_height, $source_image_width, $source_image_height);
			imagealphablending($new_image, true);
		}

		$thumb_path = $this->getThumbName($dimensions);

		imagealphablending($new_image, true);
		imagesavealpha($new_image, true);

		imagepng($new_image, PROJECT_ROOT_DIR . '/' . $thumb_path, 1);
		imagedestroy($new_image); // clear memory

		return $this;
	}

	private function getThumbName($dimensions)
	{
		$image_info = pathinfo($this->getImage());

		$thumb_dir = str_replace('/upload/images', '/upload/images/thumbs', $image_info['dirname']);
		$thumb_path = $thumb_dir . '/' . $image_info['filename'] . '_' . $dimensions . '.' . $image_info['extension'];

		if(!is_dir(PROJECT_ROOT_DIR . '/' . dirname($thumb_path)))
		{
			mkdir(PROJECT_ROOT_DIR . '/' . dirname($thumb_path), 0777, true);
		}

		return $thumb_path;
	}
	
	public static function invalidateThumbsForImage($image_url)
	{
		$image = new Libraries_Image();
		$image->setImage($image_url);
        
		$thumb_name = $image->getThumbName('0x0');
    
		$thumb_dir = dirname($thumb_name);
		$thumb_real_path = $thumb_dir . '/';
		
		$image_info = pathinfo($image_url);
		$image_name = $image_info['filename'];
    
		$dir = dir($thumb_real_path);
		while(($file = $dir->read()) !== false)
		{
			if(preg_match('/^\./', $file))
			{
				continue;
			}
    	
			if(preg_match('/^' . $image_name . '/', $file))
			{
				unlink($thumb_real_path . $file);              
			}
		}
		
		return true;
	}

	/**
	 *
	 * @param string $image_url
	 * @param string $dimensions
	 * @param int $thumb_method
	 */
	public static function getThumbFromImage($image_url, $dimensions, $thumb_method = Libraries_Image::THUMBMETHOD_FIT)
	{
		if(!file_exists(PROJECT_ROOT_DIR . $image_url))
		{
			return '';
		}
			
		$image = new Libraries_Image();
		$image->setImage($image_url);

		return $image->getThumb($dimensions, $thumb_method);
	}
}