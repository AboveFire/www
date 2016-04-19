<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Log;

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
        'uti_nom', 'uti_prenm', 'uti_code', 'uti_courl', 'uti_paswd',
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
	
}
