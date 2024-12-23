<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use App\Models\Permission;
use App\Models\Role;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use EagerLoadPivotTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guard_name = 'sanctum';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
   /* protected $appends = [
        'profile_photo_url',
    ];*/

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     *
     * @return collection
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    public function projects(): BelongsToMany
    {
         return $this->belongsToMany(Project::class, 'projects_users', 'user_id', 'project_id');
    } 

    public function allRoles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id','role_id')           
            ->using(ModelHasRoles::class)
			->withPivot('project_id');
    }

    public function allPermissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id','permission_id')			
            ->using(ModelHasPermissions::class)
            ->withPivot('project_id');
    }

    protected function getDefaultGuardName(): string { return 'sanctum'; }


}
