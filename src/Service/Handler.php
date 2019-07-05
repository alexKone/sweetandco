<?php

namespace App\Service;

use Cocur\Slugify\Slugify;

class Handler
{
	public function slugify( $name, $id ) {
		$slugify = new Slugify();
		return $slugify->slugify($name.$id, '_');
	}
}
