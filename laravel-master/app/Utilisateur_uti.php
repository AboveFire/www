<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Utilisateur_uti extends Authenticatable
{
	const CREATED_AT = 'UTI_CREATED_AT';
	const UPDATED_AT = 'UTI_UPDATED_AT';
	
	protected $primaryKey = 'UTI_SEQNC';
	
	protected $table = 'Utilisateur_uti';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uti_nom', 'uti_prenm', 'uti_code', 'uti_courl', 'uti_paswd', 'uti_image', 'uti_image_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'uti_paswd', 'uti_remember_token',
    ];
    
    public function getRememberTokenName()
    {
    	return 'UTI_REMEMBER_TOKEN';
    }

    public function getAuthPassword() {
    	return $this->UTI_PASWD;
    }
    
	public function isAdmin()
	{
		return ($this->UTI_PERMS == 'A'); // this looks for an admin column in your users table
	}
	public function isSuperAdmin()
	{
		return ($this->UTI_PERMS == 'S'); // this looks for an superadmin column in your users table
	}
	
	public function getEmailForPasswordReset()
	{
		return $this->UTI_COURL;
	}
	
	/**
	 * Get the attributes that have been changed since last sync.
	 *
	 * @return array
	 */
	public function getDirty()
	{
		$dirty = [];
	
		foreach ($this->attributes as $key => $value) {
			if (! array_key_exists($key, $this->original)) {
				if($key == 'password')
				{
					$dirty['uti_paswd'] = $value;
				}
				else 
				{
				$dirty[$key] = $value;
				}
			} elseif ($value !== $this->original[$key] &&
					! $this->originalIsNumericallyEquivalent($key)) {
						if($key == 'password')
						{
							$dirty['uti_paswd'] = $value;
						}
						else 
						{
						$dirty[$key] = $value;
						}
			}
		}
	
		return $dirty;
	}
	
	public function getImage()
	{
		$base64   = base64_encode($this->UTI_IMAGE);
		return ('data:' .'image/' . $this->UTI_TYPE_IMAGE . ';base64,' . $base64);

		//return $this->UTI_IMAGE;
	}
	
	public function getImageMobile()
	{
		$base64   = base64_encode($this->UTI_IMAGE);
		if ($base64 == '')
		{
			return '{"error":"image_not_found"}';
		}
		return ($base64);
	}
	
	public function getNomPrenm()
	{
		return $this->UTI_PRENM . ' ' . $this->UTI_NOM;
	}
	
	public function getLangue()
	{
		$listLang = DB::table('langue_lan')->select('LAN_CODE')->where('LAN_SEQNC', '=', $this->UTI_LAN_SEQNC)->get();
		$lang = "FRd";
		foreach ($listLang as $value){
			$lang = $value->LAN_CODE;
		}
		return $lang;
	}
}
