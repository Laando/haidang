<?php namespace App\Repositories;

use App\Models\Region;

class RegionRepository {

	/**
	 * The Region instance.
	 *
	 * @var App\Models\Region
	 */
	protected $region;

	/**
	 * Create a new RegiongRepository instance.
	 *
	 * @param  App\Models\Region $Region
	 * @return void
	 */
	public function __construct(Region $region)
	{
		$this->region = $region;
	}

	/**
	 * Get all Regions.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function all()
	{
		return $this->region->all();
	}

	/**
	 * Update Regions.
	 *
	 * @param  array  $inputs
	 * @return void
	 */
	public function update($inputs)
	{
		foreach ($inputs as $key => $value)
		{
            if(is_numeric($key)){
                $region = $this->region->where('id', $key)->firstOrFail();
                $region->isOutbound =isset($inputs['isOutbound_'.$key])?$inputs['isOutbound_'.$key]:0;
                $region->title = $value;
                $region->slug = khongdaurw($value);
                $region->save();
            }
		}
	}

}
