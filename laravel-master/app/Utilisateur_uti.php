<?php

namespace App;

//use Illuminate\Foundation\Auth\Utilisateur_uti as Authenticatable;

class Utilisateur_uti extends Authenticatable
{
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
	public function isAdmin()
	{
		return ($this->UTI_PERMS == 'A'); // this looks for an admin column in your users table
	}
	public function isSuperAdmin()
	{
		return ($this->UTI_PERMS == 'S'); // this looks for an superadmin column in your users table
	}
}
