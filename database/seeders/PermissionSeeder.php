<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'materi-list',
            'materi-show',
            'materi-create',
            'materi-edit',
            'materi-delete',
            'quiz-list',
            'quiz-create',
            'quiz-edit',
            'quiz-delete',
            'getStudentscore',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'view-dashboard',
            'view-user',
            'view-role',
            'view-permission',
            'view-materi',
            'view-quiz',
            'detail-quiz',
            'view-student-scores',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'view-submissions',
            'view-formtugas',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and assign specific permissions
        // Admin Role - Full Access
        $adminPermissions = $permissions; // Admin gets all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($adminPermissions);

        // Guru Role - Limited Access
        $guruPermissions = [
             'view-materi','materi-list', 'materi-create', 'materi-edit', 'materi-delete',
            'view-quiz','quiz-list', 'quiz-create', 'quiz-edit', 'quiz-delete','view-submissions','view-formtugas',
        ];
        $guruRole = Role::firstOrCreate(['name' => 'guru']);
        $guruRole->syncPermissions($guruPermissions);

        // Siswa Role - View Access Only
        $siswaPermissions = [
             'view-materi','materi-list', 'quiz-list','view-quiz','view-formtugas',
        ];
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);
        $siswaRole->syncPermissions($siswaPermissions);
    }
}
