<?php

class Build extends Eloquent {
	public $timestamps = true;

	public function modpack()
	{
		return $this->belongsTo('Modpack');
	}

	public function modversions()
	{
		return $this->belongsToMany('Modversion')->withTimestamps();
	}

	public function basebuilds()
	{
		return $this->belongsToMany('Build', 'build_bases', 'build_id', 'base_id')->withTimestamps();
	}
}

?>
