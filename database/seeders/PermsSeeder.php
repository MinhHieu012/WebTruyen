<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermsSeeder extends Seeder
{
    protected $guard_name = 'web';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRoles();
        $this->createPermissions();
    }

    private function createRoles()
    {
        $role_names = [
            User::ROLE_ADMIN,
            // User::ROLE_ADMIN_BRAND,
            User::ROLE_SEO,
            User::ROLE_CONTENT,
        ];
        foreach ($role_names as $_name) {
            Role::findOrCreate($_name, $this->guard_name);
        }
    }

    private function createPermissions()
    {
        $group_perms = [
            '01' => [
                'xem_danh_sach_nguoi_dung' => [User::ROLE_ADMIN],
                'them_nguoi_dung'          => [User::ROLE_ADMIN,],
                'sua_nguoi_dung'           => [User::ROLE_ADMIN,],
                'switch_user'              => [User::ROLE_ADMIN],
            ],
            '02' => [
                'xem_danh_sach_vai_tro' => [User::ROLE_ADMIN,],
            ],
            '03' => [
                'xem_danh_sach_quyen'    => [User::ROLE_ADMIN,],
                'sua_quyen'              => [User::ROLE_ADMIN,],
                'reset_cache_permission' => [User::ROLE_ADMIN,],
            ],
            '04' => [
                'xem_crawl_data' => []
            ],
            '05' => [
                'xem_author_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_author' => [User::ROLE_ADMIN,],
                'xoa_author' => [User::ROLE_ADMIN,],
                'them_author' => [User::ROLE_ADMIN,],
            ],
            '06' => [
                'xem_category_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_category' => [User::ROLE_ADMIN,],
                'xoa_category' => [User::ROLE_ADMIN,],
                'them_category' => [User::ROLE_ADMIN,],
            ],
            '07' => [
                'xem_story_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_story_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'them_story_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'xoa_story_data' => [User::ROLE_ADMIN,],
                'xem_chapter' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'them_chapter' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_chapter' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'xoa_chapter' => [User::ROLE_ADMIN,],
            ],
            '08' => [
                'xem_rating_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_rating_data' => [User::ROLE_ADMIN],
            ],
            '09' => [
                'xem_display_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
                'sua_display_data' => [User::ROLE_ADMIN, User::ROLE_CONTENT,],
            ]
        ];
        foreach ($group_perms as $group => $perms) {
            if (!$perms) {
                continue;
            }

            foreach ($perms as $perm => $role_ids) {
                $snake_case_perm = Str::lower(Str::snake(Str::replace(['/', ',', '(', ')', '-'], ' ', $perm)));
                $permission      = Permission::query()
                    ->where('name', $snake_case_perm)
                    ->where('guard_name', $this->guard_name)
                    ->first();
                if (!$permission) {
                    $permission = Permission::create([
                        'group'      => $group,
                        'name'       => $snake_case_perm,
                        'guard_name' => $this->guard_name
                    ]);
                    $permission->syncRoles($role_ids);
                }
                if ($permission->group != $group) {
                    $permission->update([
                        'group' => $group,
                    ]);
                }
            }
        }
    }
}
