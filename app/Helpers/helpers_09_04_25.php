<?php
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

if (! function_exists('trace')) {
    function trace($data) {
        if(!empty($data)){
            echo "<pre>";
            return print_r($data->toArray());

        }         
        return null;
    }
}



if (! function_exists('getInnerBanner')) {
    function getInnerBanner() {
        $ban_res = DB::table('wl_banners')
        ->where('banner_position','Inner Pages Top')
        ->where('status',1)
        ->inRandomOrder()
        ->first();  
        
        return isset($ban_res->banner_image) ? $ban_res->banner_image : '';
    }
}

if (! function_exists('getFlashBanner')) {
    function getFlashBanner() {
        $ban_res = Cache::remember('active_banners', 3600, function() { // Cache for 1 hour
            return DB::table('wl_flashes')
                ->select('flash_id', 'flash_image', 'flash_title', 'flash_url')
                ->where('status', 1)
                ->orderBy('sort_order', 'desc') 
                ->limit(10)
                ->get();
        });        
        return isset($ban_res) ? $ban_res : [];
    }
}

if ( ! function_exists('char_limiter'))
{
  function char_limiter($str,$len,$suffix='...')
  {
	  $str = strip_tags($str);
	  if(strlen($str)>$len)
	  {
		  $str=substr($str,0,$len).$suffix;
	  }
	  return $str;
  }
}

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...')
    {
        return \Illuminate\Support\Str::limit($value, $limit, $end);
    }
}

/*
if (!function_exists('displayImage')) {
   
function displayImage($path = null, $alt = '', $size = 'width:100px;height:100px;', $attributes = [], $useSvgPlaceholder = true)
{
    $altText = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
    $style = htmlspecialchars($size, ENT_QUOTES, 'UTF-8');
    
    // Default attributes
    $defaultAttributes = [
        'loading' => 'lazy',
        'fetchpriority' => 'low',
        'decoding' => 'async',
        'alt' => $altText,
        'style' => $style,
        'onerror' => 'this.onerror=null;this.src=\'' . generateNoImagePlaceholder($altText, $size, $useSvgPlaceholder) . '\';'
    ];
    
    // No image provided
    if (empty($path)) {
        return generateNoImagePlaceholder($altText, $size, $useSvgPlaceholder);
    }
    
    $fullPath = public_path($path);
    $imageUrl = asset($path);
    
    // Check if image exists
    if (file_exists($fullPath)) {
        $imgAttributes = array_merge($defaultAttributes, $attributes);
        $attributeString = '';
        
        foreach ($imgAttributes as $key => $value) {
            $attributeString .= " {$key}=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\"";
        }
        
        return "<img src=\"{$imageUrl}\"{$attributeString}>";
    }
    
    // Fallback to placeholder
    return generateNoImagePlaceholder($altText, $size, $useSvgPlaceholder);
}


    function generateNoImagePlaceholder($alt, $size, $useSvg = true)
    {
        $style = htmlspecialchars($size, ENT_QUOTES, 'UTF-8');
        $escapedAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
        
        if ($useSvg) {
            // SVG placeholder with properly escaped text
            $svg = sprintf(
                '<svg xmlns="http://www.w3.org/2000/svg" style="%s;background:#f5f5f5" viewBox="0 0 100 100">
                    <text x="50%%" y="50%%" dominant-baseline="middle" text-anchor="middle" 
                        fill="#666" font-family="sans-serif" font-size="12">No Image</text>
                    <text x="50%%" y="65%%" dominant-baseline="middle" text-anchor="middle" 
                        fill="#999" font-family="sans-serif" font-size="10">%s</text>
                </svg>',
                $style,
                $escapedAlt
            );
            
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        }
        
        // DIV fallback (already properly escaped)
        return sprintf(
            '<div style="%s;background:#f0f0f0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#999;">
                <span>No Image</span>
                <small>%s</small>
            </div>',
            $style,
            $escapedAlt
        );
    }
}

*/

if (!function_exists('displayImage')) {
   
    function displayImage($path = null, $alt = '', $size = 'width:100px;height:100px;', $attributes = [], $useImagePlaceholder = true)
    {
        $altText = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
        $style = htmlspecialchars($size, ENT_QUOTES, 'UTF-8');
        
        // Default attributes
        $defaultAttributes = [
            'loading' => 'lazy',
            'fetchpriority' => 'low',
            'decoding' => 'async',
            'alt' => $altText,
            'style' => $style,
            'onerror' => 'this.onerror=null;this.src=\'' . generateNoImagePlaceholder($altText, $size, $useImagePlaceholder) . '\';'
        ];
        
        // No image provided
        if (empty($path)) {
            return generateNoImagePlaceholder($altText, $size, $useImagePlaceholder);
        }
        
        $fullPath = public_path($path);
        $imageUrl = asset($path);
        
        // Check if image exists
        if (file_exists($fullPath)) {
            $imgAttributes = array_merge($defaultAttributes, $attributes);
            $attributeString = '';
            
            foreach ($imgAttributes as $key => $value) {
                $attributeString .= " {$key}=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\"";
            }
            
            return "<img src=\"{$imageUrl}\"{$attributeString}>";
        }
        
        // Fallback to placeholder
        return generateNoImagePlaceholder($altText, $size, $useImagePlaceholder);
    }
    
    /**
     * Generate "no image" placeholder (image or DIV)
     */
        function generateNoImagePlaceholder($alt, $size, $useImage = true)
        {
            $style = htmlspecialchars($size, ENT_QUOTES, 'UTF-8');
            $escapedAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
            
            if ($useImage) {
                // Return path to no_image.jpg
                return asset('assets/frontend/images/no_image.png');
                // return '<img src="' . asset('assets/frontend/images/no_image.png') . '" />';
            }
            
            // DIV fallback (already properly escaped)
            return sprintf(
                '<div style="%s;background:#f0f0f0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#999;">
                    <span>No Image</span>
                    <small>%s</small>
                </div>',
                $style,
                $escapedAlt
            );
        }
    }



if (!function_exists('generateCategoryBreadcrumbs')) {
   
    function generateCategoryBreadcrumbs($category, $separator = ' &raquo; ', $activeClass = 'active')
    {
        if (is_numeric($category)) {
            $category = Category::findOrFail($category);
        }
        elseif (is_string($category) && !($category instanceof Category)) {
            $category = Category::where('slug', $category)->firstOrFail();
        }

        $breadcrumbs = collect();
        $current = $category;
        
        while ($current) {
            $breadcrumbs->prepend($current);
            $current = $current->parent;
        }

        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        
        foreach ($breadcrumbs as $index => $crumb) {
            $isLast = $index === $breadcrumbs->count() - 1;
            
            $html .= '<li class="breadcrumb-item ' . ($isLast ? $activeClass : '') . '">';
            
            if (!$isLast) {
                $html .= '<a href="' . route('categories.show', $crumb->slug) . '">';
            }
            
            $html .= e($crumb->name);
            
            if (!$isLast) {
                $html .= '</a>';
            }
            
            $html .= '</li>';
            
            if (!$isLast) {
                $html .= $separator;
            }
        }
        
        $html .= '</ol></nav>';

        return $html;
    }
}













if (!function_exists('country_list')) {
    function country_list()
    {
        $countries = [
            "India", "Afghanistan", "Albania", "Algeria", "Am. Samoa", "Andorra", "Angola", "Anguilla", "Antarctica",
            "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain",
            "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
            "Bosnia and Herzegovina", "Botswana", "Bouvet Island", "Brazil", "Brit. Ind. Ocean Terr.", "Brunei Darussalam",
            "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands",
            "C. African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos Islands", "Colombia", "Comoros", "Congo",
            "Cook Islands", "Costa Rica", "Cote D~ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Rep.", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea",
            "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana",
            "French Polynesia", "French Southern Terr", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece",
            "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Isl",
            "Honduras", "Hong Kong", "Hungary", "Iceland", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica",
            "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "DPR of Korea", "Republic of Korea", "Kuwait", "Kyrgyzstan",
            "Lao Peoples Dem Rep", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein",
            "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta",
            "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia", "Moldova", "Monaco",
            "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands",
            "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island",
            "N Mariana Isl", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru",
            "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation",
            "Rwanda", "Saint Kitts", "Saint Lucia", "St Pierre", "St Vincent", "Samoa", "San Marino", "Sao Tome",
            "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands",
            "Somalia", "South Africa", "South GA", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden",
            "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tokelau", "Tonga",
            "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos", "Tuvalu", "Uganda", "Ukraine",
            "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City State",
            "Venezuela", "Vietnam", "Virgin Islands Brit", "Virgin Islands US", "Wallis and Futuna Isl", "Western Sahara",
            "Yemen", "Yugoslavia", "Zaire", "Zambia", "Zimbabwe"
        ];
        return $countries;
    }        

}

if (!function_exists('country_code_list')) {
    function country_code_list()
    {
        $countryCodes = [
            '' => 'Code',
            '1' => '+1 Canada',
            '1-SaintKitts' => '+1 Saint Kitts and Nevis',
            '1-SaintLucia' => '+1 Saint Lucia',
            '1-SaintVincent' => '+1 Saint Vincent and the Grenadines',
            '1-USA' => '+1 United States',
            '1-USMinor' => '+1 United States Minor Outlying Islands',
            '1-242' => '+1-242 Bahamas',
            '1-246' => '+1-246 Barbados',
            '1-264' => '+1-264 Anguilla',
            '1-268' => '+1-268 Antigua and Barbuda',
            '1-284' => '+1-284 British Indian Ocean Territory',
            '1-345' => '+1-345 Cayman Islands',
            '1-441' => '+1-441 Bermuda',
            '1-473' => '+1-473 Grenada',
            '1-649' => '+1-649 Turks and Caicos Islands',
            '1-664' => '+1-664 Montserrat',
            '1-671' => '+1-671 Guam',
            '1-767' => '+1-767 Dominica',
            '1-787' => '+1-787 Puerto Rico',
            '1-809' => '+1-809 Dominican Republic',
            '1-868' => '+1-868 Trinidad and Tobago',
            '1-876' => '+1-876 Jamaica',
            '1284' => '+1284 Virgin Islands (British)',
            '1340' => '+1340 Virgin Islands (U.S.)',
            '1670' => '+1670 Northern Mariana Islands',
            '20' => '+20 Egypt',
            '212' => '+212 Morocco',
            '213' => '+213 Algeria',
            '216' => '+216 Tunisia',
            '218' => '+218 Libya',
            '220' => '+220 Gambia',
            '221' => '+221 Senegal',
            '222' => '+222 Mauritania',
            '223' => '+223 Mali',
            '224' => '+224 Guinea',
            '225' => '+225 Cote D\'Ivoire',
            '226' => '+226 Burkina Faso',
            '227' => '+227 Niger',
            '228' => '+228 Togo',
            '229' => '+229 Benin',
            '230' => '+230 Mauritius',
            '231' => '+231 Liberia',
            '232' => '+232 Sierra Leone',
            '233' => '+233 Ghana',
            '234' => '+234 Nigeria',
            '235' => '+235 Chad',
            '236' => '+236 Central African Republic',
            '237' => '+237 Cameroon',
            '238' => '+238 Cape Verde',
            '239' => '+239 Sao Tome and Principe',
            '240' => '+240 Equatorial Guinea',
            '241' => '+241 Gabon',
            '242' => '+242 Congo, The Republic of Congo',
            '243' => '+243 Congo, The Democratic Republic Of The',
            '244' => '+244 Angola',
            '245' => '+245 Guinea-Bissau',
            '247' => '+247 Ascension Island',
            '248' => '+248 Seychelles',
            '249' => '+249 Sudan',
            '250' => '+250 Rwanda',
            '251' => '+251 Ethiopia',
            '252' => '+252 Somalia',
            '253' => '+253 Djibouti',
            '254' => '+254 Kenya',
            '255' => '+255 Tanzania',
            '255-Zanzibar' => '+255 Zanzibar',
            '256' => '+256 Uganda',
            '257' => '+257 Burundi',
            '258' => '+258 Mozambique',
            '260' => '+260 Zambia',
            '261' => '+261 Madagascar',
            '262' => '+262 Reunion',
            '263' => '+263 Zimbabwe',
            '264' => '+264 Namibia',
            '265' => '+265 Malawi',
            '266' => '+266 Lesotho',
            '267' => '+267 Botswana',
            '268' => '+268 Swaziland',
            '269' => '+269 Comoros',
            '269-Mayotte' => '+269 Mayotte',
            '27' => '+27 South Africa',
            '290' => '+290 St. Helena',
            '291' => '+291 Eritrea',
            '297' => '+297 Aruba',
            '298' => '+298 Faroe Islands',
            '299' => '+299 Greenland',
            '30' => '+30 Greece',
            '31' => '+31 Netherlands',
            '32' => '+32 Belgium',
            '33' => '+33 France',
            '33-Metropolitan' => '+33 France Metropolitan',
            '33-Southern' => '+33 French Southern Territories',
            '34' => '+34 Spain',
            '350' => '+350 Gibraltar',
            '351' => '+351 Portugal',
            '352' => '+352 Luxembourg',
            '353' => '+353 Ireland',
            '354' => '+354 Iceland',
            '355' => '+355 Albania',
            '356' => '+356 Malta',
            '357' => '+357 Cyprus',
            '358' => '+358 Aland Islands',
            '358-Finland' => '+358 Finland',
            '359' => '+359 Bulgaria',
            '36' => '+36 Hungary',
            '370' => '+370 Lithuania',
            '371' => '+371 Latvia',
            '372' => '+372 Estonia',
            '373' => '+373 Moldova',
            '374' => '+374 Armenia',
            '375' => '+375 Belarus',
            '376' => '+376 Andorra',
            '377' => '+377 Monaco',
            '378' => '+378 San Marino',
            '380' => '+380 Ukraine',
            '381' => '+381 Kosovo',
            '381-Serbia' => '+381 Serbia',
            '381-Yugoslavia' => '+381 Yugoslavia',
            '382' => '+382 Montenegro',
            '385' => '+385 Croatia (local name: Hrvatska)',
            '386' => '+386 Slovenia',
            '387' => '+387 Bosnia and Herzegovina',
            '389' => '+389 Macedonia',
            '39' => '+39 Italy',
            '39-Vatican' => '+39 Vatican City State (Holy See)',
            '40' => '+40 Romania',
            '41' => '+41 Switzerland',
            '420' => '+420 Czech Republic',
            '421' => '+421 Slovakia (Slovak Republic)',
            '423' => '+423 Liechtenstein',
            '43' => '+43 Austria',
            '44-Guernsey' => '+44 Guernsey',
            '44-IsleofMan' => '+44 Isle of Man',
            '44-Jersey' => '+44 Jersey',
            '44-SGSandSouth' => '+44 South Georgia and the South Sandwich Islands',
            '44' => '+44 United Kingdom',
            '45' => '+45 Denmark',
            '46' => '+46 Sweden',
            '47-Bouvet' => '+47 Bouvet Island',
            '47' => '+47 Norway',
            '47-Svalbard' => '+47 Svalbard and Jan Mayen Islands',
            '48' => '+48 Poland',
            '49' => '+49 Germany',
            '493' => '+493 Alderney',
            '500' => '+500 Falkland Islands (Malvinas)',
            '501' => '+501 Belize',
            '502' => '+502 Guatemala',
            // ... (shortened for readability)
            '91' => '+91 India',
            '92' => '+92 Pakistan',
            '93' => '+93 Afghanistan',
            '94' => '+94 Sri Lanka',
            '95' => '+95 Myanmar',
            '960' => '+960 Maldives',
            '961' => '+961 Lebanon',
            '962' => '+962 Jordan',
            '963' => '+963 Syrian Arab Republic',
            '964' => '+964 Iraq',
            '965' => '+965 Kuwait',
            '966' => '+966 Saudi Arabia',
            '967' => '+967 Yemen',
            '968' => '+968 Oman',
            '970' => '+970 Palestine',
            '971' => '+971 United Arab Emirates',
            '972' => '+972 Israel',
            '973' => '+973 Bahrain',
            '974' => '+974 Qatar',
            '975' => '+975 Bhutan',
            '976' => '+976 Mongolia',
            '977' => '+977 Nepal',
            '98' => '+98 Iran (Islamic Republic of)',
            '992' => '+992 Tajikistan',
            '993' => '+993 Turkmenistan',
            '994' => '+994 Azerbaijan',
            '995' => '+995 Georgia',
            '996' => '+996 Kyrgyzstan',
            '998' => '+998 Uzbekistan',
            'other' => 'Other Country',
        ];
        return $countryCodes;  
    }

}

