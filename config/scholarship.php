<?php

return [
    'gpa_value' => 3.40,
    'gpa_values' => [
        3.40,
        2.90,
    ],
    'types' => [
        [
            'key' => 'akademik',
            'name' => 'Beasiswa Akademik',
            'description' => 'Diberikan kepada mahasiswa dengan pencapaian akademik unggul.',
            'requirements' => [
                'IPK minimal 3,20',
                'Tidak memiliki nilai D atau E',
                'Aktif mengikuti kegiatan akademik kampus',
            ],
        ],
        [
            'key' => 'non_akademik',
            'name' => 'Beasiswa Non-Akademik',
            'description' => 'Ditujukan untuk prestasi di bidang seni, olahraga, atau organisasi.',
            'requirements' => [
                'IPK minimal 3,00',
                'Memiliki sertifikat prestasi non-akademik',
                'Aktif mengikuti organisasi mahasiswa',
            ],
        ],
    ],
];
