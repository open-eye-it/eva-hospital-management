<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            [
                'name'         => 'category-read',
                'display_name' => 'Read Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-create',
                'display_name' => 'create Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-update',
                'display_name' => 'update Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-status',
                'display_name' => 'status Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'user-read',
                'display_name' => 'Read User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-create',
                'display_name' => 'Create User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-update',
                'display_name' => 'Update User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-status',
                'display_name' => 'Status User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'visiting-fee-read',
                'display_name' => 'Read Visiting Fee',
                'guard_name'   => 'web',
                'section'      => 'visiting-fee',
            ],
            [
                'name'         => 'visiting-fee-update',
                'display_name' => 'Update Visiting Fee',
                'guard_name'   => 'web',
                'section'      => 'visiting-fee',
            ],
            [
                'name'         => 'trainee-read',
                'display_name' => 'Read Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-create',
                'display_name' => 'Create Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-update',
                'display_name' => 'Update Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-status',
                'display_name' => 'Status Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-certificate',
                'display_name' => 'Certificate Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-payment',
                'display_name' => 'Payment Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'room-read',
                'display_name' => 'Read Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
            [
                'name'         => 'room-create',
                'display_name' => 'Create Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
            [
                'name'         => 'room-update',
                'display_name' => 'Update Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
            [
                'name'         => 'general-medicine-read',
                'display_name' => 'Read General Medicine',
                'guard_name'   => 'web',
                'section'      => 'general-medicine',
            ],
            [
                'name'         => 'general-medicine-create',
                'display_name' => 'Create General Medicine',
                'guard_name'   => 'web',
                'section'      => 'general-medicine',
            ],
            [
                'name'         => 'general-medicine-update',
                'display_name' => 'Update General Medicine',
                'guard_name'   => 'web',
                'section'      => 'general-medicine',
            ],
            [
                'name'         => 'general-medicine-status',
                'display_name' => 'Status General Medicine',
                'guard_name'   => 'web',
                'section'      => 'general-medicine',
            ],
            [
                'name'         => 'operation-medicine-read',
                'display_name' => 'Read Operation Medicine',
                'guard_name'   => 'web',
                'section'      => 'operation-medicine',
            ],
            [
                'name'         => 'operation-medicine-create',
                'display_name' => 'Create Operation Medicine',
                'guard_name'   => 'web',
                'section'      => 'operation-medicine',
            ],
            [
                'name'         => 'operation-medicine-update',
                'display_name' => 'Update Operation Medicine',
                'guard_name'   => 'web',
                'section'      => 'operation-medicine',
            ],
            [
                'name'         => 'operation-medicine-status',
                'display_name' => 'Status Operation Medicine',
                'guard_name'   => 'web',
                'section'      => 'operation-medicine',
            ],
            [
                'name'         => 'referred-doctor-read',
                'display_name' => 'Read Referred Doctor',
                'guard_name'   => 'web',
                'section'      => 'referred-doctor',
            ],
            [
                'name'         => 'referred-doctor-create',
                'display_name' => 'Create Referred Doctor',
                'guard_name'   => 'web',
                'section'      => 'referred-doctor',
            ],
            [
                'name'         => 'referred-doctor-update',
                'display_name' => 'Update Referred Doctor',
                'guard_name'   => 'web',
                'section'      => 'referred-doctor',
            ],
            [
                'name'         => 'patient-read',
                'display_name' => 'Read Patient',
                'guard_name'   => 'web',
                'section'      => 'patient',
            ],
            [
                'name'         => 'patient-create',
                'display_name' => 'Create Patient',
                'guard_name'   => 'web',
                'section'      => 'patient',
            ],
            [
                'name'         => 'patient-update',
                'display_name' => 'Update Patient',
                'guard_name'   => 'web',
                'section'      => 'patient',
            ],
            [
                'name'         => 'patient-status',
                'display_name' => 'Status Patient',
                'guard_name'   => 'web',
                'section'      => 'patient',
            ],
            [
                'name'         => 'mac-address-read',
                'display_name' => 'Read Mac Address',
                'guard_name'   => 'web',
                'section'      => 'mac-address',
            ],
            [
                'name'         => 'mac-address-create',
                'display_name' => 'Create Mac Address',
                'guard_name'   => 'web',
                'section'      => 'mac-address',
            ],
            [
                'name'         => 'mac-address-update',
                'display_name' => 'Update Mac Address',
                'guard_name'   => 'web',
                'section'      => 'mac-address',
            ],
            [
                'name'         => 'mac-address-status',
                'display_name' => 'Status Mac Address',
                'guard_name'   => 'web',
                'section'      => 'mac-address',
            ],
            [
                'name'         => 'mac-address-remove',
                'display_name' => 'Remove Mac Address',
                'guard_name'   => 'web',
                'section'      => 'mac-address',
            ],
            [
                'name'         => 'appointment-read',
                'display_name' => 'Read Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-create',
                'display_name' => 'Create Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-edit',
                'display_name' => 'Edit Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-status',
                'display_name' => 'Status Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-prescription',
                'display_name' => 'Prescription Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-full-view',
                'display_name' => 'Full View Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-bill-print',
                'display_name' => 'Bill Print Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'appointment-additional-charge',
                'display_name' => 'Additional Charge Appointment',
                'guard_name'   => 'web',
                'section'      => 'appointment'
            ],
            [
                'name'         => 'ipd-read',
                'display_name' => 'Read IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-create',
                'display_name' => 'Create IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-edit',
                'display_name' => 'Edit IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-status',
                'display_name' => 'Status IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-opd-history',
                'display_name' => 'OPD History IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-ipd-history',
                'display_name' => 'IPD History IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-full-view',
                'display_name' => 'Full View IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-bill-amount',
                'display_name' => 'Bill Amount IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-operative-notes',
                'display_name' => 'Operative Notes IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-prescribe',
                'display_name' => 'Prescribe IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'ipd-detail-print',
                'display_name' => 'Detail Print IPD',
                'guard_name'   => 'web',
                'section'      => 'ipd'
            ],
            [
                'name'         => 'follow-up-opd-read',
                'display_name' => 'Read OPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-opd'
            ],
            [
                'name'         => 'follow-up-opd-notes',
                'display_name' => 'Notes OPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-opd'
            ],
            [
                'name'         => 'follow-up-ipd-read',
                'display_name' => 'Read IPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-ipd'
            ],
            [
                'name'         => 'follow-up-ipd-notes',
                'display_name' => 'Notes IPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-ipd'
            ],
            [
                'name'         => 'follow-up-ipd-opd-history',
                'display_name' => 'OPD History IPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-ipd'
            ],
            [
                'name'         => 'follow-up-ipd-ipd-history',
                'display_name' => 'IPD History IPD Follow Up',
                'guard_name'   => 'web',
                'section'      => 'follow-up-ipd'
            ],
            [
                'name'         => 'account-detail-opd-read',
                'display_name' => 'Read OPD Account Detail',
                'guard_name'   => 'web',
                'section'      => 'account-detail-opd'
            ],
            [
                'name'         => 'account-detail-opd-additional-charge',
                'display_name' => 'Additional Charge OPD Account Detail',
                'guard_name'   => 'web',
                'section'      => 'account-detail-opd'
            ],
            [
                'name'         => 'account-detail-ipd-read',
                'display_name' => 'Read IPD Account Detail',
                'guard_name'   => 'web',
                'section'      => 'account-detail-ipd'
            ],
            [
                'name'         => 'account-detail-ipd-bill-amount',
                'display_name' => 'Bill Amount iPD Account Detail',
                'guard_name'   => 'web',
                'section'      => 'account-detail-ipd'
            ],
            [
                'name'         => 'balance-read',
                'display_name' => 'Balance Show',
                'guard_name'   => 'web',
                'section'      => 'balance'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
