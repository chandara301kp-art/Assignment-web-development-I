<?php
session_start(); // Must be first

// ----- Helper: Build redirect URL preserving all GET params except given ones -----
function getRedirectUrl($exclude = ['add_cart', 'clear_cart']) {
    $params = $_GET;
    foreach ($exclude as $key) {
        unset($params[$key]);
    }
    $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    return $_SERVER['PHP_SELF'] . ($query ? '?' . $query : '');
}

// ----- Handle "Add to Cart" -----
if (isset($_GET['add_cart'])) {
    $id = filter_input(INPUT_GET, 'add_cart', FILTER_VALIDATE_INT);
    if ($id && $id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }
    header('Location: ' . getRedirectUrl());
    exit;
}

// ----- Handle "Clear Cart" -----
if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = [];
    header('Location: ' . getRedirectUrl());
    exit;
}

$pageTitle = "SKIN CARE - Products";
$currentYear = date("Y");

// ----- PRODUCT DATA (with unique descriptions) -----
$products = [
    [
        'id'          => 1,
        'name'        => 'WHITENING BODY LOTION',
        'image'       => './image/Black sheep.jpg',
        'rating'      => 5,
        'sale'        => 30,
        'category'    => 'Black Sheep',
        'description' => 'ឡេលាបខ្លួនបំប៉នសំណើម ធ្វើឲ្យស្បែកសភ្លឺថ្លា មិនកក មិនប្រលាក់ជាប់អាវ ស្រួលលាប ក្លិនក្រអូបស្រាល ។'
    ],
    [
        'id'          => 2,
        'name'        => 'VITAMIN WHITE GLOWING',
        'image'       => './image/body sheep.jpg',
        'rating'      => 5,
        'sale'        => 12,
        'category'    => 'Black Sheep',
        'description' => 'ជាប្រភេទទឹកអេសសិនចៀម ដាក់លាយជាមួយឡេធ្វើអោយស្បែកកាន់តែភ្លឺស ធ្វើអោយស្បែកកាន់តែGlow ជួយបំបាត់ស្នាម និងបញ្ហាសង្វា ។'
    ],
    [
        'id'          => 3,
        'name'        => 'CUSHION GLOW SKIN',
        'image'       => './image/cushion sheep.jpg',
        'rating'      => 5,
        'sale'        => 12,
        'category'    => 'Black Sheep',
        'description' => 'ជាប្រភេទខូសិនចៀម មានពីរពណ៍សម្រាប់កូដ1 សម្រាប់អ្នកស្បែកស សម្រាប់កូដ2សម្រាប់អ្នកស្បែស្រអែម លាបលើមុខធ្វើអោយមុខGlowស្អាត ជាប់បានយូរមិនកកនៅលើមុខ ។'
    ],
    [
        'id'          => 4,
        'name'        => 'PEARLY WHITE GLOW',
        'image'       => './image/pearly sheep.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Black Sheep',
        'description' => 'ជាប្រភេទសារ៉ូមគុជខ្យង ផ្តល់សំណើមមានជាតិទឹកខ្ពស់ ជួយលើបញ្ហាស្ទះរន្ធរោម ចង់បានសខ្លាំងaddជាមួយឡេបាន ។'
    ],
    [
        'id'          => 5,
        'name'        => 'COFFEE BODY SCRUB',
        'image'       => './image/scrub sheep.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Black Sheep',
        'description' => 'ពេលស្រ្កាបមិនធ្វើអោយឈឺស្បែក មិនធ្វើអោយស្បែកឡើងកន្តួលរមាស់ ជួយជម្រុះកោសិកាចាស់ៗបានល្អងាយស្រួលក្នុងការប្រើប្រាស់ឡេ ។'
    ],
    [
        'id'          => 6,
        'name'        => 'FROZEN ZONE SUNSCREEN',
        'image'       => './image/sunscreen sheep.jpg',
        'rating'      => 5,
        'sale'        => 15,
        'category'    => 'Black Sheep',
        'description' => 'ជាប្រភេទឡេការពារកម្ដៅថ្ងៃ(UV) ការពារពីកម្ដៅថ្ងៃបានល្អអត់ស្អិតពេលលាបលើស្បែក ផ្តល់សំណើមសំខាន់មានSPF ដល់ 50+++ ។'
    ],
    [
        'id'          => 7,
        'name'        => 'WHITE MILKY SPA',
        'image'       => './image/white milke spa sheep.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Black Sheep',
        'description' => ' ជាប្រភេទស្ពាស្បែក ធ្វើអោយស្បែកយើងទន់ សាកសមជាមួយអ្នកស្បែកខ្មៅខ្លាំង ខ្មៅក្រិន ទើបតែចាប់ផ្តើមលាបឡេដំបូងក្នុង1ខែអាចប្រើបាន2-3ដង , សារ៉ូមនិងគ្មានជាតិកាត់ទេហើយក៏អត់ធ្វើអោយមុខសបានដែរវាផ្តោតទៅលើតែមុនទេ។'
    ],
    [
        'id'          => 8,
        'name'        => 'YASAKA BOOSTER WHITE',
        'image'       => './image/Yasaka.jpg',
        'rating'      => 5,
        'sale'        => 22,
        'category'    => 'Yasaka',
        'description' => 'ឡេ​Yasaka ជាប្រភេទឡេ ដែលជួយជួលជុលស្បែកដែលខូច ឬកោសិកាចាស់ឲមានសំណើមវិញបាន ហើយនិងជួយឲបាត់សង្វារ ស្បែកក្រឹន ខ្មៅស្រអាប់និងមានស្នាមអ៊ុចខ្មៅ និងធ្វើឲស្បែកមានក្លិនក្រអូប ។'
    ],
    [
        'id'          => 9,
        'name'        => 'YASAKA BODY OIL',
        'image'       => './image/yasaka body oil.jpg',
        'rating'      => 5,
        'sale'        => 15,
        'category'    => 'Yasaka',
        'description' => 'ប្រេ​YASAKA ជាប្រភេទប្រេដែលជួយការពាររកម្តៅថ្ងៃហើយនិងធ្វើឲស្បែកភ្លឺរលោងនិងជួយជុលស្បែកដែលខូចហើយស្តើងស្ងួតឲប្រែមកជាក្រាស់វិញហើយ និងជួយព្យាបាលនិងទប់ស្កាត់រាល់ការឡើងសង្វារ ស្នាមអ៊ុចខ្មៅនិងអាចរុយម៌ឲមានសំណើមនិងរឹងមាំវិញ ។'
    ],
    [
        'id'          => 10,
        'name'        => 'YASAKA BODY SCRUB',
        'image'       => './image/yasaka body scrub.jpg',
        'rating'      => 5,
        'sale'        => 15,
        'category'    => 'Yasaka',
        'description' => 'ក្រាប់Yasakaជួយព្យាបាលសង្វារសរសៃក្រហមស្បែកស្តើងស្ងួត ដែលខូចនិងមានស្នាមអាចរុយម៌ ស្នាមអ៊ុចខ្មៅ មុនខ្នង ក្រិនក្រឺម និងជួយបំបាត់ក្លិនក្លៀកដុំពកនិងជួយសម្អាតគល់រោមនៃស្បែកនិងធ្វើឲលាបឡេឆាប់ចូល  និងធ្វើឲស្បែករឹងមាំហើយនិងជួយបណ្តឹងស្បែកជួយផ្តល់សំណើមដល់ស្បែក និងជួយបណ្តុះកោសិកាស្បែកហើយនិងជួយការពារកម្តៅថ្ងៃ។'
    ],
    [
        'id'          => 11,
        'name'        => 'YASAKA BODY SPA',
        'image'       => './image/yasaka spa.jpg',
        'rating'      => 5,
        'sale'        => 6,
        'category'    => 'Yasaka',
        'description' => 'ស្ប៉ាYasaka ជួយឲស្បែកទន់ភ្លឺថ្លានិងរលោងឆាប់ស ភ្លាមៗ ហើយនិងជួយកាត់បន្ថយជាតិពុលក្នុងស្បែក ។'
    ],
    [
        'id'          => 12,
        'name'        => 'YASAKA COLLAGEN TRIPEPTIDE',
        'image'       => './image/Yasaka Collagen.jpg',
        'rating'      => 5,
        'sale'        => 21,
        'category'    => 'Yasaka',
        'description' => 'Yasaka Collagen Tripeptide ញំាហើយគឺងាយជ្រាបចូលស្រទាប់កោសិកាស្បែកបានយ៉ាងលឿនល្អជាង ,🍑ជួយអោយក្មេងជាងវ័យ ប្រឆាំងភាពជ្រីជ្រួញ ,🫐ជំនួយដល់ស្មារតីបានល្អ ,🥝ជួយអោយស្បែក សភ្លឺថ្លា ,🍓ជួយអោយសក់ក្រចកដុះលូតលាស់ល្អ ,🍇ជួយបញ្ហាសន្លាក់ និងជំនួយកំលាំង ,🍒ជួយសម្រួលនៅការមករដូវអោយបានទៀងទាត់និងជួយកាត់បន្ថយបញ្ហារោគស្រ្តី ,✅ញុំាមួយថ្ងៃ1ដប ពេលព្រឹករឺមុនពេលចូលគេង ។'
    ],
    [
        'id'          => 13,
        'name'        => 'YASAKA BODY SHAPE',
        'image'       => './image/Yasaka body shape.jpg',
        'rating'      => 5,
        'sale'        => 21,
        'category'    => 'Yasaka',
        'description' => 'Yasaka body shape ជួយស្រកគីឡូលឿនដោយមិនចាំបាច់តមអាហារ និងស្រកបែបធម្មជាតិ ដោយមិនចាំបាច់ហាត់ប្រាណ ហើយមិនរាគរួស និងមិនកង្វល់និងការគាំងគីឡូ ។'
    ],
    [
        'id'          => 14,
        'name'        => 'MISS SUNFLOWER BODY LOTIAN',
        'image'       => './image/Miss flower.jpg',
        'rating'      => 5,
        'sale'        => 30,
        'category'    => 'Miss Sunflower',
        'description' => 'ជាប្រភេទឡេលាបស្បែកធ្វើអោយស្បែកស ស្បែកខ្មៅពីកំណើតក៏ប្រើបាន បំបាត់អាចម៍រុយ ធ្វើអោយស្បែកទន់ជួយបំពេញ និងជុសជុលស្បែកដែលមានបញ្ហាជួយបំបាត់សង្វា ។'
    ],
    [
        'id'          => 15,
        'name'        => 'MISS SUNFLOWER NIGHT CREAM',
        'image'       => './image/Miss night cream.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Miss Sunflower',
        'description' => 'ជាប្រភេទឡេយប់ ជួយផ្ចិតរន្ធញើសតូចធំ ជុសជុលបញ្ហាស្បែកមុខ ជួយបំបាត់រោលរមាស់ជាំ មុខសរសៃក្រហម ជួយបណ្តុះកោសិកាស្បែកមុខ ។'
    ],
    [
        'id'          => 16,
        'name'        => 'MISS SUNFLOWER BODY OIL',
        'image'       => './image/Miss flower body oil.jpg',
        'rating'      => 5,
        'sale'        => 10,
        'category'    => 'Miss Sunflower',
        'description' => '👉ជួយអោយបំបាត់មុនខ្នង ,👉បំបាត់សង្វារ ,👉ជួយឲ្យបំបាត់អាចម៍រុយ ,👉✉️ធ្វើអោយស្បែកមានសំណើម ,👉ជួយបំបាត់ស្នាមក្រិន ,👉ធ្វើអោយស្បែកសលឿន ,👉មិនមានជាតិកាត់ ។'
    ],
    [
        'id'          => 17,
        'name'        => 'MISS SUNFLOWER GOATMILK',
        'image'       => './image/Miss Goatmilk.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Miss Sunflower',
        'description' => 'ស្រ្កាប់ទឹកដោះពពែ  🌻សំរាប់ បង្ហាប់ស្បែក អោយតឹងណែន បំបាត់ភាពក្រិននិងជ្រួញតាមបរិវេណដងខ្លួនយ៉ាងមានប្រសិទ្ធភាព ។'
    ],
    [
        'id'          => 18,
        'name'        => 'BB MISS SUNFLOWER',
        'image'       => './image/BB Miss sun flower.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Miss Sunflower',
        'description' => 'ការពារពន្លឺ កំដៅថ្ងៃបានល្អ មាន𝗦𝗣𝗙 𝟰𝟬𝗽𝗮+++ ,✨ជួយ𝗧𝗼𝗻𝗲 𝘂𝗽ស្បែកមុខ ,✨មានសារធាតុ𝗦𝗲𝗿𝘂𝗺ដែលជួយផ្ដល់សំណើមដល់ស្បែក ,✨ជួយទប់ស្កាត់ការឡើងមុន រោល ផ្សេងៗ ,✨មិនស្អិត មិនកក មិនប្រតាក មិនធ្វើអោយខូចមុខ ,✨ជួយបិទបាំងស្នាមបានល្អ ,✨លាបហើយស្បែកមុខឡើង𝗚𝗹𝗼𝘄ស្អាត ។'
    ],
    [
        'id'          => 19,
        'name'        => 'MISS SUNFLOWER SCRUB COFFEE',
        'image'       => './image/Miss scrub coffee.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Miss Sunflower',
        'description' => 'Missស្រ្កាប់កាហ្វេ🌺 ចង់បានស្បែក ស ខ្ចី ញ៉េញ ស្បែកចាំ បំបាត់សង្វារ ម៉ត់ រលោង និងជួយជម្រុះកោសិកាចាស់ៗ និងជួយបំបាត់ស្នាមក្រិនក្រឺម ។'
    ],
    [
        'id'          => 20,
        'name'        => 'MISS SUNFLOWER SCRUB SRAUV SALEI',
        'image'       => './image/Miss scrub srv saley.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Miss Sunflower',
        'description' => 'Miss ស្រ្កាប់ស្រូវសាឡី ជួយជម្រុះ កោសិកាចាស់ៗ និងជួយឲស្បែកភ្លឺថ្លា  បំបាត់ស្នាមអ៊ុចខ្មៅ បំបាត់អាចរុយម៌ បំបាត់មុនខ្នង និងធ្វើឲស្បែកកាន់តែស ។'
    ],
    [
        'id'          => 21,
        'name'        => 'MISS SUNFLOWER SUNSERUM',
        'image'       => './image/Miss serum.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Miss Sunflower',
        'description' => 'ជាប្រភេទ Sunserum ជួយការពារស្បែកមុខពីភន្លឺUVA/UVB ផ្ដល់សំណើមដល់ស្បែកមុខជួយអោយស្បែកមុខ Glow ភ្លឺម៉ត់រលោង មិនកក មិនស្អិត មានSPFរហូតដល់ 50PA++++។'
    ],
    [
        'id'          => 22,
        'name'        => 'ស្ប៉ាធ្យូងឬស្សី',
        'image'       => './image/Spa NNP.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'NNP',
        'description' => 'ស្ប៉ាNNP ជួយជម្រុះកោសិកាចាស់ៗជួយជម្រុះកោសិកាស្បែកដែលងាប់ និងកម្ចាត់រាល់ភាពគ្រើមៗនៅលើស្បែក បានយ៉ាងល្អ។បំបាត់ស្នាម៖ ជួយកាត់បន្ថយស្នាមអុជខ្មៅ ស្នាមសង្វារ និងធ្វើឱ្យស្បែកមានសភាពទន់រលោង។ បើករន្ធញើស៖ ជួយសម្អាតធូលីដីនិងជាតិពុលដែលកកស្ទះ ធ្វើឱ្យស្បែកស្រូបយកឡេលាបស្បែកបានលឿនជាងមុន ទ្វេដង។ផ្តល់សំណើម៖ ជួយឱ្យស្បែកភ្លឺថ្លាចេញពីខាងក្នុង បែបធម្មជាតិ និងមិនស្ងួតរំអិល ។'
    ],
    [
        'id'          => 23,
        'name'        => 'ឡេ NNP',
        'image'       => './image/NNP ឡេ.jpg',
        'rating'      => 5,
        'sale'        => 5.5,
        'category'    => 'NNP',
        'description' => 'ឡេNNP ជួយឱ្យស្បែកសរលោង និងភ្លឺថ្លា (Whitening & Brightening)ពន្លឿនការផ្លាស់ប្តូរកោសិកាស្បែក: ជួយកាត់បន្ថយរាល់ស្នាមអុជខ្មៅ ស្នាមអុជៗលើស្បែក និងកែប្រែស្បែកដែលស្រអាប់ឱ្យមកជាសភ្លឺថ្លា បែបធម្មជាតិ។កាត់បន្ថយជាតិមេឡានីន: ជួយទប់ស្កាត់ការកកើតសារធាតុពណ៌ ដែលធ្វើឱ្យស្បែកខ្មៅស្រអាប់ដោយសារកម្តៅថ្ងៃ។២. ផ្តល់សំណើមបានជ្រៅ និងយូរអង្វែង (Deep Moisturizing)ផ្សំឡើងពីប្រេងចូចូបា (Jojoba Oil): ជួយបំប៉នស្បែកស្ងួតឱ្យត្រឡប់មកមានសំណើម ទន់ល្មើយ និងមានភាពបត់បែន។រក្សាជាតិទឹក: បង្កើតស្រទាប់ការពារដើម្បី ទប់ស្កាត់ការបាត់បង់ជាតិទឹកពីស្បែកពេញមួយថ្ងៃ។٣. ការពារស្បែកពីកម្តៅថ្ងៃ និងការបំផ្លាញពីបរិស្ថានការពារកាំរស្មី UV: ជួយការពារស្បែកមិនឱ្យខូច ឬរលាកនៅពេលត្រូវកម្តៅថ្ងៃ។ប្រឆាំងរ៉ាឌីកាល់សេរី: ជួយពង្រឹងរបាំងការពារស្បែក ធ្វើឱ្យស្បែករឹងមាំ និងមានសុខភាពល្អ។៤. កែប្រែវាយនភាពស្បែកឱ្យហាប់ណែន (Skin Smoothing)បំបាត់ភាពគ្រើម: ជួយឱ្យស្បែកត្រង់តំបន់កែងដៃ ជង្គង់ ឬកន្លែងស្ងួតខ្លាំង ប្រែមកជារលោងម៉ដ្តខៃសាច់ឡេស្រាល មិនស្អិត: ងាយស្រួលជ្រាបចូលទៅក្នុងស្បែកយ៉ាងរហ័ស មិនធ្វើឱ្យមានអារម្មណ៍រំខាន ឬស្អិតប្រឡាក់ខោអាវឡើយ ។'
    ],
    [
        'id'          => 24,
        'name'        => 'ឡេលាបខ្លួន ដុំមាស ចូចូបា',
        'image'       => './image/NNP ដុំមាស​ ចូចូបា.jpg',
        'rating'      => 5,
        'sale'        => 15,
        'category'    => 'NNP',
        'description' => 'ផលិតដោយកូនខ្មែរ ជួយអោយស្បែកសម៉ដ្ឋរលោងសង្វាមុនខ្នងនៅលើស្បែកគ្រប់ប្រភេទជួយផ្ដល់សំណើមពីខាងក្នុងមានSPFរហូតដល់50+++អ្នកដែលមាន ស្បែកខ្លាំងក៏ប្រើបានសំខាន់ធ្វើអោយស្បែកកាន់តែស តម្លៃ15$។'
    ],
    [
        'id'          => 25,
        'name'        => 'មេសេរ៉ូមស្លេក',
        'image'       => './image/NNP មេសេរ៉ូម.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'NNP',
        'description' => 'ជួយឱ្យស្បែកសភ្លឺថ្លា៖ បន្សាបរាល់ជាតិពុល និងកោសិកាចាស់ៗ ដើម្បីឱ្យស្បែកប្រែជាស បែបផ្កាឈូក និងមានសំណើម។បំប៉នខ្លាំងជាងវីតាមីន C៖ មានសមត្ថភាពជ្រាបចូលទៅចិញ្ចឹមស្រទាប់ស្បែកយ៉ាងជ្រៅ និងផ្តល់អាហារបំប៉នដល់ស្បែកខ្ពស់ជាងឡេធម្មតា ឬវីតាមីន C ដល់ទៅ ១០ដង។កាត់បន្ថយស្នាម៖ ជួយកាត់បន្ថយរាល់ស្នាមអុជខ្មៅ ស្នាមសន្លាក និងស្នាមជាំផ្សេងៗនៅលើស្បែកដងខ្លួន។ផ្តល់សំណើមខ្ពស់៖ ការពារស្បែកមិនឱ្យស្ងួត ក្រៀមក្រំ ឬប្រេះស្រកា ដោយសារកម្តៅថ្ងៃ ឬម៉ាស៊ីនត្រជាក់​ ។'
    ],
    [
        'id'          => 26,
        'name'        => 'NNP NIGHT CREAM',
        'image'       => './image/NNP Night Cream.jpg',
        'rating'      => 5,
        'sale'        => 3,
        'category'    => 'NNP',
        'description' => 'Night Cream ជួយព្យាបាលរាល់បញ្ហាស្បែកមុខ មុខជាំអាចម៍រុយ ជួយបំប៉នស្បែកមុខឲទន់ភ្លឺរលោង មានសំណើមកាត់បន្ថយភាពជ្រីវជ្រួញជួយអោយស្បែកតឹងណែននិងស្រស់ស្អាត។'
    ],
    [
        'id'          => 27,
        'name'        => 'ស្ក្រាប់ប្រពៃណី',
        'image'       => './image/NNP ស្ក្រាប់ប្រពៃណី.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'NNP',
        'description' => 'បំបាត់កោសិកាស្បែកដែលងាប់ និងធូលីដីកខ្វក់។កម្ចាត់ភាពគ្រើម៖ ធ្វើឱ្យស្បែកទន់រលោង ជាពិសេសត្រង់កែងដៃ និងជង្គង់។ស្បែកសភ្លឺថ្លា៖ ជួយកាត់បន្ថយស្នាមអុជខ្មៅ និងធ្វើឱ្យពណ៌ស្បែកស្មើគ្នា។បើករន្ធរោម៖ ជួយសម្អាតរន្ធរោមឱ្យជ្រៅ ការពារការកើតមុនលើរាងកាយ។ស្រូបឡេបានល្អ៖ ជួយឱ្យស្បែកងាយស្រូបយកជីវជាតិពីឡេលាបស្បែកបានទ្វេដង។'
    ],
    [
        'id'          => 28,
        'name'        => 'ប្រេង NNP',
        'image'       => './image/NNP ប្រេងចូចូបា.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'NNP',
        'description' => 'ប្រេងNNP កាត់បន្ថយនិងការពារសង្វារ៖ ជួយបំបាត់ស្នាមសង្វារចាស់ៗ និងការពារមិនឱ្យបែកសង្វារថ្មី ជាពិសេសស័ក្តិសមបំផុតសម្រាប់ស្រ្តីមានផ្ទៃពោះ។ស្តារស្បែកខូច៖ ជួយជួសជុល និងពង្រឹងកោសិកាស្បែកឡើងវិញ សម្រាប់អ្នកដែលធ្លាប់ប្រើប្រាស់ឡេខុស ឬមានស្បែកខ្សោយ។ផ្តល់សំណើមស៊ីជម្រៅ៖ ជួយឱ្យស្បែកទន់រលោង មានទឹកមានដក់ មិនស្ងួតក្រៀម។បំបាត់ស្នាម និងអាចម៍រុយ៖ ជួយសម្រួលដល់ស្នាមអុជខ្មៅ ស្នាមរបួស និងកាត់បន្ថយអាចម៍រុយលើស្បែក។ព្យាបាលការរលាក និងរមាស់៖ ជួយសម្រាលការកន្ទួលរមាស់ និងស្បែកដែលរលាកដោយសារកម្តៅថ្ងៃ។បង្កើនប្រសិទ្ធភាពឡេ៖ នៅពេលយកទៅលាយជាមួយឡេលាបស្បែក វាជួយឱ្យឡេជ្រាបចូលស្បែកបានល្អ និងផ្តល់ស្បែកសភ្លឺថ្លាជាងមុន។ '
    ],
    [
        'id'          => 29,
        'name'        => 'សាប៊ូដុសខ្លូន ផ្លែល្ហុង',
        'image'       => './image/NNP សាប៊ូដុសខ្លួន.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Black Sheep',
        'description' => 'សាប៊ូដុសខ្លួន NNPជួយសម្អាតស្បែកយ៉ាងជ្រៅ៖ លាងជម្រះភាពកខ្វក់ ជាតិខ្លាញ់ និងបាក់តេរីដែលកកកុញនៅលើរាងកាយបានយ៉ាងល្អ។ជួយឱ្យស្បែកភ្លឺថ្លា៖ សារធាតុផ្សំអាចជួយកម្ចាត់ កោសិកាស្បែកចាស់ៗ និងជម្រុញឱ្យស្បែកសភ្លឺថ្លា ឬម៉ដ្ឋរលោងជាងមុន។ផ្ដល់សំណើមនិងទន់រលោង៖ ជួយចិញ្ចឹមស្បែក មិនធ្វើឱ្យស្បែកស្ងួត ឬតឹងបន្ទាប់ពីងូតទឹករួច។ផ្ដល់ក្លិនក្រអូបប្រហើរ៖ បន្សល់នូវក្លិនក្រអូបជាប់នៅលើដងខ្លួនជួយឱ្យអ្នកមានអារម្មណ៍ស្រស់ស្រាយពេញមួយថ្ងៃ។'
    ],
    [
        'id'          => 30,
        'name'        => 'សេរ៉ូមបំប៉នស្បែក ចូចូបា',
        'image'       => './image/NNP សេរ៉ូមបំប៉នស្បែក.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'NNP',
        'description' => 'សេរ៉ូមបំប៉នស្បែក ជួយកាត់បន្ថយបញ្ហាស្បែកខ្មៅស្រអាប់ជួយទប់និងបង្កើនជាតិសំណើមដល់ស្បែកសាច់ឡេស្រាល មិនស្អិតត្រជាក់មានក្លិនក្រអូបលាបងាយចូលស្បែកកាត់បន្ថយស្បែកមិនឲមានការជ្រីវជ្រួញ ។'
    ],
    [
        'id'          => 31,
        'name'        => 'ម៉ាស់ Lucaci ពណ៌បៃតង (Lucaci Acne Mask)',
        'image'       => './image/Lucaci Mask.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Lucaci',
        'description' => 'ម៉ាស់ Lucaci ពណ៌បៃតង (Lucaci Acne Mask)មុខងារចម្បង៖ ផ្តោតលើការព្យាបាលមុន និងបំបាត់រាល់បញ្ហាស្បែកមុខមុន។អត្ថប្រយោជន៍៖ជួយកម្ចាត់ជាតិប្រេង បង្រួមរន្ធញើសធំៗ និងកាត់បន្ថយមុខខ្លាញ់។ ព្យាបាលមុខរោល មុនកប់ មុនខ្ទុះ និងមុនក្បាលខ្មៅ។មានសារធាតុ Peppermint ជួយឱ្យស្បែកត្រជាក់ និង Relax។ជួយលុប និងកាត់បន្ថយស្នាមដែលបន្សល់ពីមុន។ '
    ],
    [
        'id'          => 32,
        'name'        => 'ម៉ាស់ Lucaci ពណ៌ផ្កាឈូក (Lucaci Acne Mask)',
        'image'       => './image/Lucasi Mask pink.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Lucaci',
        'description' => ' ម៉ាស់Lucaci ពណ៌ផ្កាឈូកកាត់បន្ថយភាពស្រអាប់៖ ជួយឱ្យស្បែកមុខប្រែជាសស្អាត ភ្លឺថ្លា និងមានផ្កាឈូក។ផ្តល់សំណើមខ្ពស់៖ បំពេញជាតិទឹកដល់ស្បែកយ៉ាងជ្រៅ មិនធ្វើឱ្យស្ងួតមុខឡើយ។បំបាត់ស្នាម៖ ជួយកាត់បន្ថយរាល់ស្នាមអុជខ្មៅ និងស្នាមផ្សេងៗនៅលើផ្ទៃមុខ។បន្តឹងស្បែក៖ ជួយឱ្យស្បែកមុខមានភាពតឹងណែន និងទន់រលោង។'
    ],
    [
        'id'          => 33,
        'name'        => 'Lucaci Alovera hair removal sugar wax combinatio',
        'image'       => './image/Lucaci Alovera hair removal sugar wax combination.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Lucaci',
        'description' => 'គឺជាប្រភេទស្ករត្រជាក់ បករោមបានស្អាត បកបានច្រើន បកដោយទាំងគល់ មិនបន្សល់រន្ធរោម មិនឲរលាក ក្តៅស្បែក '
    ],
    [
        'id'          => 34,
        'name'        => 'ឡេក្លៀក Lucaci',
        'image'       => './image/Lucaci ឡេក្លៀក.jpg',
        'rating'      => 5,
        'sale'        => 6,
        'category'    => 'Lucaci',
        'description' => 'លេក្លៀក ជួយថែទាំស្បែកក្លៀក អោយភ្លឺ រលោងកាត់បន្ថយក្លិន កាត់បន្ថយរមាស់និងបញ្ហាស្បែកក្លៀកផ្សេងៗទៀតធ្វើអោយក្លៀកស្អាតមានទំនុកចិត្ត សមស្រមសម្រាប់គ្រប់ប្រភេទស្បែក និងស្បែកងាយប្រតិកម្មក៏ប្រើបាន  '
    ],
    [
        'id'          => 35,
        'name'        => 'LUCACI TONER',
        'image'       => './image/Lucaci Toner.jpg',
        'rating'      => 5,
        'sale'        => 8,
        'category'    => 'Lucaci',
        'description' => ' ជាប្រភេទទឹកជូនមុខ(Toner) ផ្តល់សំណើមខ្ពស់និងជួយសម្រាប់ស្បែកមុខស្រអាប់ស្នាមអុចខ្មៅ ជួយបង្រួមរន្ធញើស ជួយបំបាត់មុនមុខតូចៗ ជួយអោយស្បែកភ្លឺថ្លារលោង ជួយសម្អាតស្បែកមុខពីធូលីដីបានល្អ ជាពិសេសការ Remove makeup '
    ],
    [
        'id'          => 36,
        'name'        => 'ហ្វូមលាងមុខ LUCACI ពណ៏ផ្កាឈូក',
        'image'       => './image/Lucaci ហ្វូមលាងមុខ​ ផ្កាឈូក.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Lucaci',
        'description' => 'ហ្វូមលាងមុខ សម្រាប់ពណ៍ផ្កាឈូក ប្រើសម្រាប់មុខស្ងួត ស្ដើងសរសៃក្រហមមុខខ្សោយកាត់បន្ថយស្នាមអុចខ្មៅធ្វើអោយមុខម៉ដ្ឋរលោងក្មេងជាងវ័យកាត់បន្ថយការស្ទះរន្ធរោមពង្រឹងរនាំងស្បែកមុខ'
    ],
    [
        'id'          => 37,
        'name'        => 'ហ្វូមលាងមុខ LUCACI ពណ៏បៃតង',
        'image'       => './image/Lucaci ហ្វូមលាងមុខ​ បៃតង.jpg',
        'rating'      => 5,
        'sale'        => 5,
        'category'    => 'Lucaci',
        'description' => 'សម្រាប់ពណ៍ បៃតង ប្រើសម្រាប់ស្បែកមុខមានមុនគ្រប់ប្រភេទ មុខងាយប្រតិកម្ម មានខ្លាញ់ ប្រេង ក៏អាចប្រើបាន និងជួយកាត់បន្ថយការរោល  '
    ],
    [
        'id'          => 38,
        'name'        => 'សំឡីជូតមុខពណ៍ផ្កាឈូក',
        'image'       => './image/Lucaci សំឡីជូតមុខ ផ្កាឈូក.jpg',
        'rating'      => 5,
        'sale'        => 6,
        'category'    => 'Lucaci',
        'description' => ' សំឡីជូតមុខពណ៍ផ្កាឈូក ប្រើសម្រាប់ស្បែកមុខស្ងួត ជួយបំបាត់ជាំ អាចម៍រុយ ធ្វើអោយស្បែកមុខភ្លឺ ក្មេងជាងវ័យ និងជួយផ្តល់សំណើមដល់ស្បែកមុខ  '
    ],
    [
        'id'          => 39,
        'name'        => 'សំឡីជូតមុខពណ៍បៃតង',
        'image'       => './image/Lucaci សំឡីជូតមុខ បៃតង.jpg',
        'rating'      => 5,
        'sale'        => 6,
        'category'    => 'Lucaci',
        'description' => 'សំឡីជូតមុខពណ៍បៃតង ប្រើសម្រាប់ស្បែកមុខខ្លាញ់ ប្រេង មានមុន ស្នាមសល់ពីការញិចមុន ជួយបំបាត់មុននានា ជួយកម្ចាត់ធូលីដីពីលើស្បែកមុខបានល្អ និងជួយបង្រួមរន្ធញើស '
    ],
];

// ----- PRODUCT DETAIL LOGIC -----
$detailId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$detailProduct = null;
if ($detailId > 0) {
    foreach ($products as $p) {
        if ($p['id'] === $detailId) {
            $detailProduct = $p;
            break;
        }
    }
}

// ----- SEARCH & CATEGORY FILTERING (only used for grid view) -----
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$filteredProducts = $products;

if ($search !== '') {
    $filteredProducts = array_filter($filteredProducts, function($product) use ($search) {
        return stripos($product['name'], $search) !== false;
    });
}

if ($category !== 'all') {
    $filteredProducts = array_filter($filteredProducts, function($product) use ($category) {
        return strcasecmp($product['category'], $category) === 0;
    });
}

// Category list for the dropdown
$categories = ['All', 'Black Sheep', 'Yasaka', 'Miss Sunflower', 'NNP', 'Lucaci'];

// ----- PAGINATION MAPPING (page number → category) -----
$categoryPages = [
    1 => 'all',
    2 => 'Black Sheep',
    3 => 'Yasaka',
    4 => 'Miss Sunflower',
    5 => 'NNP',
    6 => 'Lucaci'
];
$currentPage = array_search($category, $categoryPages);
if ($currentPage === false) $currentPage = 1; // default to All

// Build search parameter for pagination links
$searchParam = $search ? '&search=' . urlencode($search) : '';
?>
>
<html>
<head>

    <title><?php echo $pageTitle; ?></title>
    <!-- Google Fonts: Inter + Khmer (Noto Sans Khmer) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ----- RESET & BASE ----- */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Noto Sans Khmer', sans-serif;
            background: radial-gradient(circle at 20% 30%, #fdf2f8 0%, #fce7f3 40%, #f5f0ff 100%);
            color: #2d2a3a;
            line-height: 1.5;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ----- HEADER / NAV ----- */
        .header {
            background: linear-gradient(135deg, #ffe4e9 0%, #ffd9e2 50%, #fdd9e8 100%);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(180, 80, 120, 0.10);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #b14a6b;
            text-transform: uppercase;
        }
        .logo span {
            color: #f5a3b9;
        }

        #menu-toggle {
            display: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .nav-links > li {
            position: relative;
        }

        .nav-links a,
        .nav-links .dropbtn {
            color: #4a3a4a;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: color 0.25s ease, transform 0.2s;
            position: relative;
            white-space: nowrap;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .nav-links a::after,
        .nav-links .dropbtn::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: #b14a6b;
            transition: width 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links .dropbtn:hover {
            color: #b14a6b;
            transform: translateY(-1px);
        }
        .nav-links a:hover::after,
        .nav-links .dropbtn:hover::after {
            width: 100%;
        }

        .nav-links a.active,
        .nav-links .dropbtn.active {
            color: #b14a6b;
        }
        .nav-links a.active::after,
        .nav-links .dropbtn.active::after {
            width: 100%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffffdd;
            backdrop-filter: blur(8px);
            min-width: 160px;
            box-shadow: 0 8px 24px rgba(150, 60, 100, 0.15);
            border-radius: 16px;
            padding: 8px 0;
            z-index: 10;
            margin-top: 8px;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .nav-links li:focus-within .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #3d2a3a;
            padding: 10px 20px;
            display: block;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            border-radius: 8px;
            margin: 2px 8px;
        }

        .dropdown-content a:hover {
            background: #fdd9e8;
            color: #b14a6b;
        }

        .dropdown-content a.active-cat {
            background: #b14a6b;
            color: #fff;
        }

        .nav-search {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .nav-search input[type="text"] {
            padding: 8px 18px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            color: #2d2a3a;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            width: 180px;
        }
        .nav-search input[type="text"]::placeholder {
            color: #9a7a8a;
        }
        .nav-search input[type="text"]:focus {
            border-color: #b14a6b;
            background: #ffffffcc;
            box-shadow: 0 0 0 4px rgba(177, 74, 107, 0.15);
        }
        .nav-search button {
            background: #b14a6b;
            border: none;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(177, 74, 107, 0.25);
        }
        .nav-search button:hover {
            background: #d46a8a;
            transform: scale(1.03);
            box-shadow: 0 6px 14px rgba(177, 74, 107, 0.35);
        }
        .nav-search .clear-btn {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            color: #4a3a4a;
            padding: 8px 14px;
            font-size: 13px;
            border-radius: 50px;
            transition: background 0.2s, color 0.2s;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .nav-search .clear-btn:hover {
            background: #b14a6b;
            color: #fff;
            border-color: #b14a6b;
        }

        /* ----- PAGE SECTION ----- */
        .page-section {
            padding: 60px 0 80px;
            background: transparent;
        }
        .page-section .container {
            max-width: 1000px;
        }
        .page-content {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            padding: 40px 48px;
            border-radius: 32px;
            box-shadow: 0 8px 40px rgba(150, 60, 100, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .page-content h2 {
            font-size: 32px;
            font-weight: 700;
            color: #2d1f2a;
            margin-bottom: 8px;
        }
        .page-content .subhead {
            font-size: 18px;
            color: #6a4a5a;
            margin-bottom: 24px;
        }

        .search-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }
        .search-result-info {
            font-size: 15px;
            color: #6a4a5a;
        }
        .search-clear-link {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: #b14a6b;
            padding: 6px 20px;
            border-radius: 30px;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(177, 74, 107, 0.2);
        }
        .search-clear-link:hover {
            background: #d46a8a;
            transform: translateY(-2px);
        }

        /* ----- PRODUCT GRID ----- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
            margin-top: 10px;
        }
        .product-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 18px 16px 20px;
            box-shadow: 0 4px 20px rgba(150, 60, 100, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            border: 1px solid rgba(255, 215, 225, 0.5);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(177, 74, 107, 0.12);
        }
        .product-image {
            width: 100%;
            height: 160px;
            overflow: hidden;
            border-radius: 16px;
            background: #fce7f3;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        .product-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .product-rating {
            margin: 12px 0 6px;
            color: #f5a3b9;
            font-size: 18px;
            letter-spacing: 2px;
        }
        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #2d1f2a;
            margin-bottom: 6px;
            line-height: 1.3;
            min-height: 40px;
        }
        .product-prices {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }
        .original-price {
            font-size: 16px;
            color: #b5a0a8;
            text-decoration: line-through;
        }
        .sale-price {
            font-size: 22px;
            font-weight: 700;
            color: #b14a6b;
        }
        .add-to-cart {
            display: inline-block;
            background: #b14a6b;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 28px;
            border-radius: 50px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 12px rgba(177, 74, 107, 0.2);
        }
        .add-to-cart:hover {
            background: #d46a8a;
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(177, 74, 107, 0.3);
        }

        /* Detail view */
        .detail-back-link {
            display: inline-block;
            margin-top: 20px;
            color: #b14a6b;
            font-weight: 600;
            transition: color 0.2s;
        }
        .detail-back-link:hover {
            color: #d46a8a;
            text-decoration: underline;
        }
        .detail-container {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            margin: 30px 0;
        }
        .detail-image {
            flex: 1;
            min-width: 250px;
        }
        .detail-image img {
            width: 100%;
            border-radius: 24px;
        }
        .detail-info {
            flex: 2;
            min-width: 250px;
        }
        .detail-info .price {
            font-size: 24px;
            font-weight: 700;
            color: #b14a6b;
        }
        .detail-info .rating {
            margin: 10px 0;
            color: #f5a3b9;
            font-size: 22px;
        }
        .detail-info .description {
            margin: 20px 0;
            color: #4a3a4a;
            line-height: 1.7;
            font-family: 'Noto Sans Khmer', sans-serif;
            white-space: pre-wrap;
        }
        .detail-info .meta {
            margin: 10px 0;
        }

        .no-results {
            text-align: center;
            padding: 40px 0;
            color: #6a4a5a;
        }
        .no-results p {
            font-size: 18px;
        }

        /* ----- CUSTOMER CARE ----- */
        .customer-care {
            margin-top: 50px;
            padding-top: 40px;
            border-top: 2px solid rgba(255, 215, 225, 0.5);
        }
        .customer-care h3 {
            font-size: 24px;
            font-weight: 700;
            color: #2d1f2a;
            margin-bottom: 20px;
            text-align: center;
        }
        .care-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px 20px;
            justify-content: center;
        }
        .care-links li {
            text-align: center;
        }
        .care-links a {
            display: block;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            border-radius: 30px;
            font-size: 15px;
            font-weight: 500;
            color: #3d2a3a;
            transition: background 0.2s, color 0.2s, transform 0.2s, box-shadow 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .care-links a:hover {
            background: #b14a6b;
            color: #fff;
            transform: translateY(-3px);
            border-color: #b14a6b;
            box-shadow: 0 6px 16px rgba(177, 74, 107, 0.2);
        }

        /* ----- PAGINATION ----- */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid rgba(255, 215, 225, 0.5);
        }

        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: 0 12px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            color: #4a3a4a;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: background 0.2s, color 0.2s, transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .page-btn:hover {
            background: #fdd9e8;
            color: #b14a6b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(177, 74, 107, 0.15);
        }

        .page-btn.active {
            background: #b14a6b;
            color: #fff;
            border-color: #b14a6b;
            box-shadow: 0 4px 12px rgba(177, 74, 107, 0.25);
        }

        .page-btn.active:hover {
            background: #d46a8a;
            border-color: #d46a8a;
        }

        .page-btn.prev,
        .page-btn.next {
            font-size: 20px;
            padding: 0 16px;
        }

        /* ----- FOOTER ----- */
        .footer {
            background: rgba(255, 228, 233, 0.7);
            backdrop-filter: blur(4px);
            color: #5a4a5a;
            padding: 32px 0;
            text-align: center;
            font-size: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
        }
        .footer a {
            color: #b14a6b;
            font-weight: 600;
            transition: color 0.2s;
        }
        .footer a:hover {
            color: #d46a8a;
            text-decoration: underline;
        }
        .footer .container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 820px) {
            .nav-links {
                gap: 14px;
            }
            .nav-links a,
            .nav-links .dropbtn {
                font-size: 13px;
            }
            .nav-search input[type="text"] {
                width: 140px;
            }
        }

        @media (max-width: 700px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                padding-top: 16px;
                border-top: 1px solid rgba(255, 255, 255, 0.5);
                gap: 12px;
            }

            #menu-toggle:checked ~ .container .nav-links {
                display: flex;
            }

            .nav-links a,
            .nav-links .dropbtn {
                font-size: 16px;
                padding: 6px 0;
            }

            .dropdown-content {
                position: static;
                box-shadow: none;
                backdrop-filter: none;
                background: transparent;
                padding: 0;
                margin: 0;
                border-radius: 0;
                width: 100%;
                border: none;
            }
            .dropdown-content a {
                padding: 8px 0 8px 20px;
                font-size: 15px;
                color: #5a4a5a;
                margin: 0;
                border-radius: 0;
            }
            .dropdown-content a:hover {
                background: transparent;
                color: #b14a6b;
            }
            .dropdown-content a.active-cat {
                background: transparent;
                color: #b14a6b;
            }

            .header .container {
                flex-wrap: wrap;
            }

            .nav-search {
                order: 3;
                flex: 1 1 100%;
                margin-top: 8px;
                justify-content: flex-end;
            }
            .nav-search input[type="text"] {
                flex: 1;
                width: auto;
            }

            .page-content {
                padding: 24px 20px;
                backdrop-filter: blur(4px);
            }
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 16px;
            }
            .product-name {
                font-size: 14px;
                min-height: 32px;
            }
            .sale-price {
                font-size: 18px;
            }
            .care-links {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .page-btn {
                min-width: 38px;
                height: 38px;
                font-size: 13px;
                padding: 0 10px;
            }
            .page-btn.prev,
            .page-btn.next {
                font-size: 18px;
                padding: 0 12px;
            }
            .detail-container {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 20px;
            }
            .page-content h2 {
                font-size: 26px;
            }
            .product-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .product-card {
                padding: 12px;
            }
            .product-image {
                height: 120px;
            }
            .product-rating {
                font-size: 14px;
            }
            .product-name {
                font-size: 13px;
                min-height: 30px;
            }
            .add-to-cart {
                font-size: 12px;
                padding: 8px 16px;
            }
            .care-links {
                grid-template-columns: 1fr;
            }
            .customer-care h3 {
                font-size: 20px;
            }
            .pagination {
                gap: 5px;
                flex-wrap: wrap;
            }
            .page-btn {
                min-width: 34px;
                height: 34px;
                font-size: 12px;
                padding: 0 8px;
            }
        }
    </style>
</head>
<body>

    <!-- ====== HEADER ====== -->
    <header class="header">
        <div class="container">
            <input type="checkbox" id="menu-toggle">
            <div class="logo">SKIN<span>CARE</span></div>
            <nav>
                <ul class="nav-links" id="navLinks">
                    <li>
                        <button class="dropbtn active" id="productsDropdownBtn">PRODUCTS</button>
                        <ul class="dropdown-content" id="categoryDropdown">
                            <?php
                            foreach ($categories as $cat):
                                $catParam = ($cat === 'All') ? 'all' : $cat;
                                $isActive = ($catParam === $category) ? 'active-cat' : '';
                                $href = '?page=products';
                                if ($search) $href .= '&search=' . urlencode($search);
                                $href .= '&category=' . urlencode($catParam);
                            ?>
                                <li><a href="<?php echo $href; ?>" class="<?php echo $isActive; ?>"><?php echo htmlspecialchars($cat); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Search Form -->
            <form class="nav-search" method="get" action="">
                <input type="hidden" name="page" value="products">
                <input type="text" name="search" placeholder="Search…" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">🔍</button>
                <?php if ($search !== ''): ?>
                    <a href="?page=products<?php echo ($category !== 'all') ? '&category=' . urlencode($category) : ''; ?>" class="clear-btn">✕</a>
                <?php endif; ?>
            </form>

            <label class="hamburger" for="menu-toggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
    </header>

    <!-- ====== PAGE CONTENT ====== -->
    <section class="page-section">
        <div class="container">
            <div class="page-content">

                <?php if ($detailProduct): ?>
                    <!-- ===== PRODUCT DETAIL VIEW ===== -->
                    <h2><?php echo htmlspecialchars($detailProduct['name']); ?></h2>
                    <div class="detail-container">
                        <div class="detail-image">
                            <img src="<?php echo $detailProduct['image']; ?>" alt="<?php echo htmlspecialchars($detailProduct['name']); ?>">
                        </div>
                        <div class="detail-info">
                            <div class="price">$<?php echo number_format($detailProduct['sale']); ?></div>
                            <div class="rating"><?php echo str_repeat('★', $detailProduct['rating']); ?></div>
                            <p class="description"><?php echo nl2br(htmlspecialchars($detailProduct['description'])); ?></p>
                            <div class="meta"><strong>Category:</strong> <?php echo htmlspecialchars($detailProduct['category']); ?></div>
                            <div class="meta"><strong>Product ID:</strong> #<?php echo $detailProduct['id']; ?></div>
                            <?php
                            $addParams = ['add_cart=' . $detailProduct['id']];
                            if ($search) $addParams[] = 'search=' . urlencode($search);
                            if ($category !== 'all') $addParams[] = 'category=' . urlencode($category);
                            $addLink = '?' . implode('&', $addParams);
                            ?>
                            <a href="<?php echo $addLink; ?>" class="add-to-cart" style="display:inline-block; margin-top:20px;">Add to Cart</a>
                            <?php
                            $backParams = [];
                            if ($search !== '') $backParams[] = 'search=' . urlencode($search);
                            if ($category !== 'all') $backParams[] = 'category=' . urlencode($category);
                            $backQuery = $backParams ? '&' . implode('&', $backParams) : '';
                            ?>
                            <a href="?page=products<?php echo $backQuery; ?>" class="detail-back-link">← Back to products</a>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- ===== PRODUCT GRID VIEW ===== -->
                    <h2>Our Products</h2>
                    <p class="subhead">Discover our range of premium skincare products.</p>

                    <?php if ($search !== ''): ?>
                        <div class="search-info">
                            <span class="search-result-info">
                                Found <?php echo count($filteredProducts); ?> product(s) for “<?php echo htmlspecialchars($search); ?>”
                            </span>
                            <a href="?page=products<?php echo ($category !== 'all') ? '&category=' . urlencode($category) : ''; ?>" class="search-clear-link">Clear search</a>
                        </div>
                    <?php endif; ?>

                    <div class="product-grid">
                        <?php if (count($filteredProducts) > 0): ?>
                            <?php foreach ($filteredProducts as $product): ?>
                                <div class="product-card">
                                    <a href="?id=<?php echo $product['id']; ?><?php 
                                        if ($search !== '') echo '&search=' . urlencode($search);
                                        if ($category !== 'all') echo '&category=' . urlencode($category);
                                    ?>" class="product-link">
                                        <div class="product-image">
                                            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        </div>
                                    </a>
                                    <div class="product-rating">
                                        <?php echo str_repeat('★', $product['rating']); ?>
                                    </div>
                                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <div class="product-prices">
                                        <span class="sale-price">$<?php echo number_format($product['sale']); ?></span>
                                    </div>
                                    <?php
                                    $addParams = ['add_cart=' . $product['id']];
                                    if ($search) $addParams[] = 'search=' . urlencode($search);
                                    if ($category !== 'all') $addParams[] = 'category=' . urlencode($category);
                                    $addLink = '?' . implode('&', $addParams);
                                    ?>
                                    <a href="<?php echo $addLink; ?>" class="add-to-cart">Add to cart</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-results" style="grid-column:1/-1;">
                                <p>No products found matching your criteria.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- ===== DYNAMIC PAGINATION ===== -->
                    <div class="pagination">
                        <?php
                        foreach ($categoryPages as $pageNum => $catVal) {
                            $catParam = ($catVal === 'all') ? '' : 'category=' . urlencode($catVal);
                            $link = '?' . $catParam . $searchParam;
                            if ($link === '?') $link = '?';
                            $active = ($pageNum == $currentPage) ? 'active' : '';
                            echo '<a href="' . $link . '" class="page-btn ' . $active . '">' . $pageNum . '</a>';
                        }
                        ?>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- ====== FOOTER ====== -->
    <footer class="footer">
        <div class="container">
            <p>
                <a href="#">@copyright Assignment Web Development I by IU-KP Year2 Year3</a>
            </p>
        </div>
    </footer>

</body>
</html>