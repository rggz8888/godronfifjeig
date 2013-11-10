
		$object = '/attach/'.$attach['filename'];
		if($this->bcs_is_object_exist($object)) {
			$this->bcs_delete($object);
			if($attach['filetype'] == 'image') {
				$object_thumb = image::thumb_name($object);
				$this->bcs_delete($object_thumb);
			}
		}