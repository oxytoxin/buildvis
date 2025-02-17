<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $region_code
 * @property string $province_code
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityMunicipality whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCityMunicipality {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $region_code
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProvince {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRegion {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $region_id
 * @property int $province_id
 * @property int $city_municipality_id
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereCityMunicipalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingInformation whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperShippingInformation {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

