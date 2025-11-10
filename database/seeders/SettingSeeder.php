<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::truncate();


        \App\Models\Setting::insert([
            [
                'type' => 'text',
                'key' => 'google_play_link',
                'value' => 'https://play.google.com/store/apps',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'app_store_link',
                'value' => 'https://www.apple.com/eg/app-store/',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'facebook_link',
                'value' => 'https://facebook.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'linkedin_link',
                'value' => 'https://linkedin.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'instagram_link',
                'value' => 'https://instagram.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'twitter_link',
                'value' => 'https://twitter.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'snapchat_link',
                'value' => 'https://snapchat.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'whatsapp_link',
                'value' => 'https://api.whatsapp.com/send?phone=201062670675',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'youtube_link',
                'value' => 'https://youtube.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'tiktok_link',
                'value' => 'https://tiktok.com',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'website_address',
                'value' => 'طريق الملك سعود - غرب مركز المعارك الثقافي بريدة القصيم',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'website_phone',
                'value' => '01062670675',
                'note' => null
            ],
            [
                'type' => 'text',
                'key' => 'website_email',
                'value' => 'info@poscast.com',
                'note' => null
            ],
            [
                'type' => 'image',
                'key' => 'download_section_mockup',
                'value' => 'https://podqasti.com/assets/podcasti/images/333.png',
                'note' => 'ratio( 1.5 : 1 )  ex  640px*420px'
            ],
            [
                'type' => 'image',
                'key' => 'review_section_image',
                'value' => 'website-assets/images/testimonial-img.png',
                'note' => null
            ],
            [
                'type' => 'image',
                'key' => 'categories_pattern',
                'value' => 'website-assets/images/categoriesavif.avif',
                'note' => 'ratio( 3.75 : 1 ) with max width 1900px'
            ],
            [
                'type' => 'image',
                'key' => 'articles_pattern',
                'value' => 'website-assets/images/footer-bg.png',
                'note' => 'ratio( 2  :   1 )  with max width  1900px'
            ],
            [
                'type' => 'image',
                'key' => 'reviews_pattern',
                'value' => 'website-assets/images/testimonial-bk.png',
                'note' => 'ratio( 2  :   1 )  with max width  1900px'
            ],
            [
                'type' => 'image',
                'key' => 'about_app_image',
                'value' => 'website-assets/images/Podcast-Illustration.jpg',
                'note' => null
            ],
            [
                'type' => 'image',
                'key' => 'contact_us_pattern',
                'value' => 'website-assets/images/contact-bk.webp',
                'note' => null
            ],
            [
                'type' => 'video',
                'key' => 'become_podcaster_video',
                'value' => 'website-assets/images/be-podcast.mp4',
                'note' => null
            ],
            [
                'type' => 'audio',
                'key' => 'main_audio_mp3',
                'value' => 'https://tympanus.net/Development/AudioPlayer/audio/BlueDucks_FourFlossFiveSix.mp3',
                'note' => null
            ],
            [
                'type' => 'audio',
                'key' => 'main_audio_wav',
                'value' => 'https://tympanus.net/Development/AudioPlayer/audio/BlueDucks_FourFlossFiveSix.wav',
                'note' => null
            ],
            [
                'type' => 'audio',
                'key' => 'main_audio_ogg',
                'value' => 'https://tympanus.net/Development/AudioPlayer/audio/BlueDucks_FourFlossFiveSix.ogg',
                'note' => null
            ],

            // other settings here 
        ]);


        /** translated settings */

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'about_app',
            'trans_value' => ['en' => 'Podcaster is a platform dedicated to podcasters and podcast listeners. Whether you’re creating your first podcast or following your favorite shows, Podcaster provides a seamless experience for both creators and audiences. Our mission is to empower voices and connect them with the world.', 'ar' => 'بودكاستر هو منصة مخصصة لمنشئي البودكاست ومستمعي البودكاست. سواء كنت تنشئ البودكاست الأول لك أو تتابع برامجك المفضلة، يوفر بودكاستر تجربة سلسة لكل من المبدعين والجمهور. مهمتنا هي تمكين الأصوات وربطها بالعالم.']
        ]);

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'about_mission_1',
            'trans_value' => ['en' => 'Podcaster is a platform dedicated to podcasters and podcast listeners. Whether you’re creating your first podcast or following your favorite shows, Podcaster provides a seamless experience for both creators and audiences. Our mission is to empower voices and connect them with the world.', 'ar' => 'بودكاستر هو منصة مخصصة لمنشئي البودكاست ومستمعي البودكاست. سواء كنت تنشئ البودكاست الأول لك أو تتابع برامجك المفضلة، يوفر بودكاستر تجربة سلسة لكل من المبدعين والجمهور. مهمتنا هي تمكين الأصوات وربطها بالعالم.']
        ]);

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'about_mission_2',
            'trans_value' => ['en' => 'Podcaster is a platform dedicated to podcasters and podcast listeners. Whether you’re creating your first podcast or following your favorite shows, Podcaster provides a seamless experience for both creators and audiences. Our mission is to empower voices and connect them with the world.', 'ar' => 'بودكاستر هو منصة مخصصة لمنشئي البودكاست ومستمعي البودكاست. سواء كنت تنشئ البودكاست الأول لك أو تتابع برامجك المفضلة، يوفر بودكاستر تجربة سلسة لكل من المبدعين والجمهور. مهمتنا هي تمكين الأصوات وربطها بالعالم.']
        ]);

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'about_mission_3',
            'trans_value' => ['en' => 'Podcaster is a platform dedicated to podcasters and podcast listeners. Whether you’re creating your first podcast or following your favorite shows, Podcaster provides a seamless experience for both creators and audiences. Our mission is to empower voices and connect them with the world.', 'ar' => 'بودكاستر هو منصة مخصصة لمنشئي البودكاست ومستمعي البودكاست. سواء كنت تنشئ البودكاست الأول لك أو تتابع برامجك المفضلة، يوفر بودكاستر تجربة سلسة لكل من المبدعين والجمهور. مهمتنا هي تمكين الأصوات وربطها بالعالم.']
        ]);

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'terms_conditions',
            'trans_value' => ['en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.', 'ar' => 'لوريم إيبسوم دولار سيت أميت، كونسيكتيتور أديبيسكينغ إليت. سِد دو إيوسيمود تيمبور إنكِدِيدِنت أوت لابوري إت دولوري ماجنا أليكوا. أوت إينيم أد مينيم فينيام، كويس نوستريد إكسرسيتاشن أولاَمكو لابوريس نيسي أوت أليكويب إكس إيا كومودو كونسيكوات. ديويس أوت إيور دولور إن ريبريهيندريت.']
        ]);

        \App\Models\Setting::create([
            'type' => 'trans_text',
            'key' => 'privacy_policy',
            'trans_value' => ['en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.', 'ar' => 'لوريم إيبسوم دولار سيت أميت، كونسيكتيتور أديبيسكينغ إليت. سِد دو إيوسيمود تيمبور إنكِدِيدِنت أوت لابوري إت دولوري ماجنا أليكوا. أوت إينيم أد مينيم فينيام، كويس نوستريد إكسرسيتاشن أولاَمكو لابوريس نيسي أوت أليكويب إكس إيا كومودو كونسيكوات. ديويس أوت إيور دولور إن ريبريهيندريت.']
        ]);


    }
}
