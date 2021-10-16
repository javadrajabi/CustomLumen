<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $domain domain
@property varchar $createdate createdate
@property varchar $country country
@property varchar $ostan ostan
@property varchar $shahrestan shahrestan
@property varchar $bakhsh bakhsh
@property varchar $shahr shahr
@property varchar $abadi abadi
@property varchar $status status
@property varchar $title title
@property varchar $author author
@property varchar $copyright copyright
@property varchar $keywords keywords
@property varchar $description description
@property varchar $script script
@property varchar $enamad enamad
@property varchar $samandehi samandehi
@property varchar $contact contact
@property varchar $tel tel
@property varchar $fax fax
@property varchar $email email
@property varchar $googlemap googlemap
@property varchar $googleplus googleplus
@property varchar $instagram instagram
@property varchar $facebook facebook
@property varchar $twitter twitter
@property varchar $linkedin linkedin
@property varchar $skype skype
@property varchar $telegram telegram
@property varchar $aparat aparat
@property varchar $youtube youtube
@property varchar $contacttitle contacttitle
@property longtext $contacttext contacttext
@property varchar $abouttitle abouttitle
@property varchar $rss rss
@property varchar $favicon favicon
@property varchar $logo logo
@property varchar $logo2 logo2
@property varchar $loginattempts loginattempts
@property varchar $banduration banduration
@property \Illuminate\Database\Eloquent\Collection $gallery hasMany
@property \Illuminate\Database\Eloquent\Collection $member hasMany
@property \Illuminate\Database\Eloquent\Collection $service hasMany
   
 */
class Setting extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'setting';

    /**
    * Mass assignable columns
    */
    protected $fillable=['banduration',
'name',
'domain',
'createdate',
'country',
'ostan',
'shahrestan',
'bakhsh',
'shahr',
'abadi',
'status',
'title',
'author',
'copyright',
'keywords',
'description',
'script',
'enamad',
'samandehi',
'contact',
'tel',
'fax',
'email',
'googlemap',
'googleplus',
'instagram',
'facebook',
'twitter',
'linkedin',
'skype',
'telegram',
'aparat',
'youtube',
'contacttitle',
'contacttext',
'abouttitle',
'rss',
'favicon',
'logo',
'logo2',
'loginattempts',
'banduration'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * galleries
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function galleries()
    {
        return $this->hasMany(Gallery::class,'portalid');
    }
    /**
    * members
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function members()
    {
        return $this->hasMany(Member::class,'portalid');
    }
    /**
    * services
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function services()
    {
        return $this->hasMany(Service::class,'portalid');
    }



}