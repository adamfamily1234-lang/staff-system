<?php

namespace Database\Seeders;

use App\Models\SkillCategory;
use App\Models\SkillCluster;
use App\Models\SkillMaster;
use Illuminate\Database\Seeder;

class StructuredSkillMasterSeeder extends Seeder
{
    public function run(): void
    {
        $clusters = [];
        $categories = [];
        $clusters['PM'] = SkillCluster::updateOrCreate(
            ['code' => 'PM'],
            [
                'name' => "Pengurusan & Pelaksanaan",
                'description' => "Keupayaan merancang, menyelaras dan melaksanakan projek, acara, operasi serta logistik.",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        $categories['PM-PROJ'] = SkillCategory::updateOrCreate(
            ['code' => 'PM-PROJ'],
            [
                'skill_cluster_id' => $clusters['PM']->id,
                'name' => "Pengurusan Projek",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-01'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Perancangan Projek",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-02'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Penjadualan Projek",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-03'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Pengurusan Bajet",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-04'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Pemantauan Kemajuan",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-05'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Pengurusan Risiko Projek",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-06'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Penyelarasan Pasukan Projek",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-07'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Pengurusan Skop",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-PROJ-08'],
            [
                'skill_category_id' => $categories['PM-PROJ']->id,
                'name' => "Pengurusan Kontrak Projek",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['PM-EVENT'] = SkillCategory::updateOrCreate(
            ['code' => 'PM-EVENT'],
            [
                'skill_cluster_id' => $clusters['PM']->id,
                'name' => "Pengurusan Acara & Protokol",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-01'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Event Manager",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-02'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Penyelaras Majlis",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-03'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Urus Setia Program",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-04'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Floor Manager",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-05'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Pengurusan Protokol Rasmi",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-06'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Penyelarasan VVIP",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-07'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Pengurusan Atur Cara",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-EVENT-08'],
            [
                'skill_category_id' => $categories['PM-EVENT']->id,
                'name' => "Pengurusan Tetamu & Jemputan",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['PM-OPS'] = SkillCategory::updateOrCreate(
            ['code' => 'PM-OPS'],
            [
                'skill_cluster_id' => $clusters['PM']->id,
                'name' => "Operasi & Logistik",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-01'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Penyelarasan Operasi Harian",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-02'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Pengurusan Logistik",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-03'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Pengurusan Aset",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-04'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Penyelarasan Vendor",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-05'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Pengurusan SOP",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-06'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Pengurusan Tapak",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-07'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Perancangan Sumber",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'PM-OPS-08'],
            [
                'skill_category_id' => $categories['PM-OPS']->id,
                'name' => "Penyelarasan Fasiliti",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $clusters['TF'] = SkillCluster::updateOrCreate(
            ['code' => 'TF'],
            [
                'name' => "Teknikal & Fungsian",
                'description' => "Keupayaan teknikal, analitikal, digital dan inovasi yang menyokong fungsi teras organisasi.",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        $categories['TF-TECH'] = SkillCategory::updateOrCreate(
            ['code' => 'TF-TECH'],
            [
                'skill_cluster_id' => $clusters['TF']->id,
                'name' => "Kemahiran Teknikal / Kejuruteraan / Reka Bentuk",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-01'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Penyediaan Spesifikasi Teknikal",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-02'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Semakan Lukisan Teknikal",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-03'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Reka Bentuk Kejuruteraan",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-04'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Pemeriksaan Teknikal",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-05'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Troubleshooting Teknikal",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-06'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Pematuhan Standard & Kod",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-07'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Penyeliaan Kerja Tapak",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-TECH-08'],
            [
                'skill_category_id' => $categories['TF-TECH']->id,
                'name' => "Pengujian & Pentauliahan",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['TF-ANALYTIC'] = SkillCategory::updateOrCreate(
            ['code' => 'TF-ANALYTIC'],
            [
                'skill_cluster_id' => $clusters['TF']->id,
                'name' => "Analisis & Penyelesaian Masalah",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-01'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Analisis Data",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-02'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Root Cause Analysis",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-03'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Penyelesaian Masalah Kompleks",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-04'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Analisis Risiko",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-05'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Pengoptimuman Proses",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-06'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Analisis Trend",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-07'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Penyiasatan Isu Teknikal",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-ANALYTIC-08'],
            [
                'skill_category_id' => $categories['TF-ANALYTIC']->id,
                'name' => "Decision Analysis",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['TF-DIGITAL'] = SkillCategory::updateOrCreate(
            ['code' => 'TF-DIGITAL'],
            [
                'skill_cluster_id' => $clusters['TF']->id,
                'name' => "Kefasihan Digital & Inovasi",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-01'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Microsoft Excel",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-02'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Google Sheets",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-03'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Google Apps Script",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-04'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Power BI",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-05'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "AutoCAD",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-06'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "BIM",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-07'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Revit",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-08'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Automasi Aliran Kerja",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-09'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Integrasi Sistem",
                'display_order' => 9,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-10'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Reka Bentuk Dashboard",
                'display_order' => 10,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-11'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "Pengurusan Data",
                'display_order' => 11,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'TF-DIGITAL-12'],
            [
                'skill_category_id' => $categories['TF-DIGITAL']->id,
                'name' => "AI Productivity Tools",
                'display_order' => 12,
                'is_active' => true,
            ]
        );

        $clusters['KS'] = SkillCluster::updateOrCreate(
            ['code' => 'KS'],
            [
                'name' => "Komunikasi & Hubungan Strategik",
                'description' => "Keupayaan menyampaikan maklumat, membina hubungan, memudah cara dan menghasilkan komunikasi profesional.",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        $categories['KS-COMM'] = SkillCategory::updateOrCreate(
            ['code' => 'KS-COMM'],
            [
                'skill_cluster_id' => $clusters['KS']->id,
                'name' => "Komunikasi & Persembahan",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-01'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Pengacara Majlis",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-02'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Public Speaking",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-03'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Moderator",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-04'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Pembentangan Eksekutif",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-05'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Taklimat Teknikal",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-06'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Pitching Idea",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-07'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Komunikasi Krisis",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-COMM-08'],
            [
                'skill_category_id' => $categories['KS-COMM']->id,
                'name' => "Storytelling Profesional",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['KS-STAKE'] = SkillCategory::updateOrCreate(
            ['code' => 'KS-STAKE'],
            [
                'skill_cluster_id' => $clusters['KS']->id,
                'name' => "Pengurusan Pemegang Taruh",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-01'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Stakeholder Engagement",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-02'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Rundingan",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-03'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Pengurusan Klien",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-04'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Hubungan Agensi Luar",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-05'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Pengurusan Kontraktor",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-06'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Pengendalian Aduan",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-07'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Consensus Building",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-STAKE-08'],
            [
                'skill_category_id' => $categories['KS-STAKE']->id,
                'name' => "Relationship Management",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $categories['KS-FACIL'] = SkillCategory::updateOrCreate(
            ['code' => 'KS-FACIL'],
            [
                'skill_cluster_id' => $clusters['KS']->id,
                'name' => "Fasilitasi & Coaching",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-01'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Fasilitasi Bengkel",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-02'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Fasilitasi Mesyuarat",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-03'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Mentoring",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-04'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Coaching",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-05'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Train-the-Trainer",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-06'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Bimbingan Rakan Sekerja",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-FACIL-07'],
            [
                'skill_category_id' => $categories['KS-FACIL']->id,
                'name' => "Knowledge Sharing",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        $categories['KS-WRITE'] = SkillCategory::updateOrCreate(
            ['code' => 'KS-WRITE'],
            [
                'skill_cluster_id' => $clusters['KS']->id,
                'name' => "Penulisan Profesional / Teknikal",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-01'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penulisan Kertas Kerja",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-02'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penulisan Laporan Teknikal",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-03'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penyediaan Minit Mesyuarat",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-04'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penulisan Memo Rasmi",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-05'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penyediaan Briefing Note",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-06'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penulisan SOP",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-07'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Dokumentasi Projek",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KS-WRITE-08'],
            [
                'skill_category_id' => $categories['KS-WRITE']->id,
                'name' => "Penulisan Ucapan",
                'display_order' => 8,
                'is_active' => true,
            ]
        );

        $clusters['LS'] = SkillCluster::updateOrCreate(
            ['code' => 'LS'],
            [
                'name' => "Kepimpinan & Sikap Kerja",
                'description' => "Keupayaan memimpin, membuat keputusan, mengambil inisiatif serta menyesuaikan diri dengan perubahan.",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        $categories['LS-LEAD'] = SkillCategory::updateOrCreate(
            ['code' => 'LS-LEAD'],
            [
                'skill_cluster_id' => $clusters['LS']->id,
                'name' => "Kepimpinan Pasukan",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-01'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Delegasi",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-02'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Motivasi Pasukan",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-03'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Membuat Keputusan",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-04'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Penyelesaian Konflik",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-05'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Pembangunan Pasukan",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-06'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Penyelarasan Pasukan Pelbagai Disiplin",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-LEAD-07'],
            [
                'skill_category_id' => $categories['LS-LEAD']->id,
                'name' => "Pengurusan Prestasi Pasukan",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        $categories['LS-AGILE'] = SkillCategory::updateOrCreate(
            ['code' => 'LS-AGILE'],
            [
                'skill_cluster_id' => $clusters['LS']->id,
                'name' => "Inisiatif & Kebolehsuaian",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-01'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Cepat Belajar",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-02'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Adaptasi Perubahan",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-03'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Inisiatif Kendiri",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-04'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Problem Ownership",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-05'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Kerja Dalam Tekanan",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-06'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Pengurusan Keutamaan",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'LS-AGILE-07'],
            [
                'skill_category_id' => $categories['LS-AGILE']->id,
                'name' => "Continuous Improvement",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        $clusters['KK'] = SkillCluster::updateOrCreate(
            ['code' => 'KK'],
            [
                'name' => "Kreatif & Kandungan",
                'description' => "Keupayaan menghasilkan kandungan, visual dan media yang menyokong komunikasi serta penyampaian organisasi.",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        $categories['KK-VISUAL'] = SkillCategory::updateOrCreate(
            ['code' => 'KK-VISUAL'],
            [
                'skill_cluster_id' => $clusters['KK']->id,
                'name' => "Reka Bentuk Visual & Multimedia",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-01'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Graphic Design",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-02'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Presentation Design",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-03'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Infografik",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-04'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Canva",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-05'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Adobe Photoshop",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-06'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Adobe Illustrator",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-VISUAL-07'],
            [
                'skill_category_id' => $categories['KK-VISUAL']->id,
                'name' => "Motion Graphics",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

        $categories['KK-MEDIA'] = SkillCategory::updateOrCreate(
            ['code' => 'KK-MEDIA'],
            [
                'skill_cluster_id' => $clusters['KK']->id,
                'name' => "Fotografi & Videografi",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-01'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Fotografi Acara",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-02'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Fotografi Korporat",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-03'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Videografi",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-04'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Video Editing",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-05'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Pengurusan Produksi Video",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-MEDIA-06'],
            [
                'skill_category_id' => $categories['KK-MEDIA']->id,
                'name' => "Live Streaming",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        $categories['KK-CONTENT'] = SkillCategory::updateOrCreate(
            ['code' => 'KK-CONTENT'],
            [
                'skill_cluster_id' => $clusters['KK']->id,
                'name' => "Kandungan & Media Digital",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-01'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Content Planning",
                'display_order' => 1,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-02'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Copywriting",
                'display_order' => 2,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-03'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Social Media Management",
                'display_order' => 3,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-04'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Content Moderation",
                'display_order' => 4,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-05'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Digital Campaign",
                'display_order' => 5,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-06'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Content Curation",
                'display_order' => 6,
                'is_active' => true,
            ]
        );

        SkillMaster::updateOrCreate(
            ['code' => 'KK-CONTENT-07'],
            [
                'skill_category_id' => $categories['KK-CONTENT']->id,
                'name' => "Web Content Management",
                'display_order' => 7,
                'is_active' => true,
            ]
        );

    }
}
