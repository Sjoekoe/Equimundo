<?php
namespace EQM\Models\Horses;

interface Horse
{
    // Genders
    const GELDING = 1;
    const MARE = 2;
    const STALLION = 3;

    // Colors
    const BAY = 1;
    const CHESTNUT = 2;
    const BLACK = 3;
    const BRINDLE = 4;
    const BUCKSKIN = 5;
    const CHAMPAGNE = 6;
    const CREAM = 7;
    const CREMELLO = 8;
    const DUN = 9;
    const GRAY = 10;
    const LEOPARD = 11;
    const PALOMINO = 12;
    const PEARL = 13;
    const PERLINO = 14;
    const PINTO = 15;
    const RABICANO = 16;
    const ROAN = 17;
    const SILVER_DAPPLE = 18;
    const SMOKEY_BLACK = 19;
    const SMOKEY_CREAM = 20;
    const WHITE = 21;

    // Breeds
    const ABTENAUER = 1;
    const ABYSSIAN = 2;
    const AEIGIDIENBERGER = 3;
    const AKHAL_TEKE = 4;
    const ALBANIAN = 5;
    const ALTAI = 6;
    const AM_CREAM = 7;
    const AM_INDIAN = 8;
    const AM_PAINT = 9;
    const AM_QUARTER = 10;
    const AM_SADDLE = 11;
    const AM_WARM = 12;
    const ANDALUSIAN = 13;
    const ANDRAVIDA = 14;
    const ANGLO_ARABIAN = 15;
    const ANGLO_KADARBA = 16;
    const APPALOOSA = 17;
    const ARAAPPALOOSA = 18;
    const ARABIAN = 19;
    const ARDENNES = 20;
    const ARENBERG = 21;
    const ASTURCON = 22;
    const AUGERON = 23;
    const AUS_DRAUGHT = 24;
    const AUS_STOCK = 25;
    const AUS_WARM = 26;
    const AUVERGNE = 27;
    const AUXOIS = 28;
    const AZERBAIJAN = 29;
    const AZTECA = 30;
    const BAISE = 31;
    const BALIKUN = 32;
    const BALUCHI = 33;
    const BANEI = 34;
    const BANKER = 35;
    const BARB = 36;
    const BARDIGIANO = 37;
    const BASQUE = 38;
    const BAVARIAN = 39;
    const BELGIAN = 40;
    const BELGIAN_WARM = 41;
    const BLACK_FOREST = 42;
    const BLAZER = 43;
    const BOULONNAIS = 44;
    const BRANDENBURGER = 45;
    const BRASILEIRO = 46;
    const BRETON = 47;
    const BRUMBY = 48;
    const BUDYONNY = 49;
    const BURQUETTE = 50;
    const BYELORUSSIAN = 51;
    const CALABRESE = 52;
    const CAMARGUE = 53;
    const CAMARILLO = 54;
    const CAMPOLINA = 55;
    const CANADIAN = 56;
    const CANADIAN_PACER = 57;
    const CAROLINA = 58;
    const CASPIAN = 59;
    const CASTILLONAIS = 60;
    const CATRIA = 61;
    const ROMANO = 62;
    const CHILEAN = 63;
    const CHOCTAW = 64;
    const CLEVELAND = 65;
    const CLYDESDALE = 66;
    const COLORADO = 67;
    const COLDBLOOD_TROTTER = 68;
    const COMTOIS = 69;
    const CORSICAN = 70;
    const COSTA_RICAN = 71;
    const CRIOLLO = 72;
    const CROATIAN = 73;
    const CUBAN = 74;
    const CUMBERLAND = 75;
    const CURLY = 76;
    const CZECH = 77;
    const DANISH = 78;
    const DANUBE = 79;
    const DOLE = 80;
    const DONGOLA = 81;
    const DRAFT = 82;
    const DUTCH_HARNESS = 83;
    const DUTCH_HEAVY = 84;
    const KWPN = 85;
    const EAST_BULGARIAN = 86;
    const ESTONIAN_DRAFT = 87;
    const ESTONIAN = 88;
    const FALABELLA = 89;
    const FINNHORSE = 90;
    const FJORD = 91;
    const FLORIDA_CRACKER = 92;
    const FOUTA = 93;
    const FREDERIKSBORG = 94;
    const FREIBERGER = 95;
    const FRENCH_TROTTER = 96;
    const FRYSIAN_CROSS = 97;
    const FRYSIAN = 98;
    const FRYSIAN_SPORT = 99;
    const FURIOSO = 100;
    const GALICENO = 101;
    const GALICIAN = 102;
    const GELDERLAND = 103;
    const GEORGIAN = 104;
    const GIARA = 105;
    const GIDRON = 106;
    const GRONINGER = 107;
    const GYPSY = 108;
    const HACKNEY = 109;
    const HAFLINGER = 110;
    const HANOVERIAN = 111;
    const HECK = 112;
    const HEIHE = 113;
    const HENSON = 114;
    const HIRZAI = 115;
    const HISPANO_BRETON = 116;
    const HISPANO_ARAB = 117;
    const HOLSTEINER = 118;
    const HUNGARIAN = 119;
    const ICELANDIC = 120;
    const INDIAN = 121;
    const IOMUD = 122;
    const IRISH_DRAUGHT = 123;
    const IRISH_SPORT = 124;
    const ITALIAN_DRAFT = 125;
    const ITALIAN_TROTTER = 126;
    const JACA = 127;
    const JEJU = 128;
    const JUTLAND = 129;
    const KABARDA = 130;
    const KAIMANAWA = 131;
    const KALMYK = 132;
    const KARABAIR = 133;
    const KARABACKH = 134;
    const KATHIAWARI = 135;
    const KAZAKH = 136;
    const KENTUCKY = 137;
    const KIGER = 138;
    const KINSKY = 139;
    const KISBER = 140;
    const KISO = 141;
    const KLADRUBER = 142;
    const KNAPSTRUPPER = 143;
    const KONIK = 144;
    const KUSTANAIR = 145;
    const LATVIAN = 146;
    const LIPPIZAN = 147;
    const LITHUANIAN = 148;
    const LOKAI = 149;
    const LOSINO = 150;
    const LUSITANO = 151;
    const MALOPOLSKI = 152;
    const MALLORQUIN = 153;
    const MANGALARGA = 154;
    const MANGALARGA_MARCHADOR = 155;
    const MAREMANO = 156;
    const MARISENO = 157;
    const MARWARI = 158;
    const MECKLENBURGER = 159;
    const MEDIMURJE = 160;
    const MENORQUIN = 161;
    const MERENS = 162;
    const MESSARA = 163;
    const MINIATURE = 164;
    const MISAKI = 165;
    const MISSOURI = 166;
    const MONCHINA = 167;
    const MONGOLIAN = 168;
    const MONTERUFOLINA = 169;
    const MORAB = 170;
    const MORGAN = 171;
    const MOYLE = 172;
    const MURAKOZ = 173;
    const MURGEZE = 174;
    const MUSTANG = 175;
    const NAMIB = 176;
    const NANGCHEN = 177;
    const SHOW_HORSE = 178;
    const NEZ = 179;
    const NIVERNAIS = 180;
    const NOKOTA = 181;
    const NONIUS = 182;
    const NORDLANDHEST = 183;
    const NORIKER = 184;
    const NORMAN = 185;
    const NORTH_SWEDISH = 186;
    const NOVOKIRGHIZ = 187;
    const OBERLANDER = 188;
    const OLDENBURGER = 189;
    const ORLOV = 190;
    const OSTFRIESEN = 191;
    const PAMPA = 192;
    const PASO_FINO = 193;
    const PENTRO = 194;
    const PERCHERON = 195;
    const PERSANO = 196;
    const PERUVIAN = 197;
    const PiNTABIAN = 198;
    const PLEVEN = 199;
    const POITVIN = 200;
    const POSAVOC = 201;
    const PRYOR = 202;
    const PRZEWALSKI = 203;
    const PUROSANGUE = 204;
    const QUATGANI = 205;
    const QUARAB = 206;
    const RACKING = 207;
    const RETUERTA = 208;
    const RHENISH = 209;
    const RHINELANDER = 210;
    const RIWOCHE = 211;
    const ROCKY_MOUNTAIN = 212;
    const ROMANIAN = 213;
    const RUSSIAN_DON = 214;
    const RUSSIAN_DRAFT = 215;
    const RUSSIAN_TROTTER = 216;
    const SALERNO = 217;
    const SAMOLACO = 218;
    const SAN_FRATELLO = 219;
    const SARCIDANO = 220;
    const SARDINIAN = 221;
    const SCHLESWIG = 222;
    const SELLA_ITALIANO = 223;
    const SELLE_FRANCAIS = 224;
    const SHAAYA = 225;
    const SHIRE = 226;
    const SICILIANO = 227;
    const SILESIAN = 228;
    const SORRAIA = 229;
    const SOKOLSKI = 230;
    const SOUTH_GERMAN = 231;
    const SOVIET = 232;
    const SPANISH_JENNET = 233;
    const SPANISH_MUSTANG = 234;
    const SPANISH_NORMAN = 235;
    const SPOTTED = 236;
    const STANDARDBRED = 237;
    const SUFFOLK = 238;
    const SWEDISH_ARDENNES = 239;
    const SWEDISH_WARM = 240;
    const SWISS_WARM = 241;
    const TAISHUH = 242;
    const TAWLEED = 243;
    const TENNESSEE = 244;
    const TERSK = 245;
    const THOROUGHBRED = 246;
    const TIGER = 247;
    const TOLFETANO = 248;
    const TORI = 249;
    const TRAIT_DU_NORD = 250;
    const TRAKEHNER = 251;
    const UKRAINIAN = 252;
    const UMOL = 253;
    const UZUNYAYLA = 254;
    const VENTASSO = 255;
    const VIRGINIA = 256;
    const VLAAMPERD = 257;
    const VLADIMIR = 258;
    const WALER_HORSE = 259;
    const WALER = 260;
    const WALKALOOSA = 261;
    const WARLANDER = 262;
    const WESTPHALIAN = 263;
    const WIELKOPOLSKI = 264;
    const WURTTEMBERGER = 265;
    const XILINGOL = 266;
    const YAKUTIAN = 267;
    const YILI = 268;
    const YONAGUNI = 269;
    const ZWEIBRUCKER = 270;
    const AM_WALKING = 271;
    const ANADOLU = 272;
    const AUS_PONY = 273;
    const AUS_RIDING_PONY = 274;
    const BALI = 275;
    const BASHKIR = 276;
    const BASUTO = 277;
    const BATAK = 278;
    const BOER = 279;
    const BOSNIAN = 280;
    const BRITISH_SPOTTED = 281;
    const BURMESE = 282;
    const CARPATHIAN = 283;
    const CANADIAN_RUSTIC = 284;
    const CHINOTEAGUE = 285;
    const CHINESE = 286;
    const COFFIN_BAY = 287;
    const CONNEMARA = 288;
    const CZECH_PONY = 289;
    const DALES = 290;
    const DANISH_PONY = 291;
    const DARTMOOR = 292;
    const DELI = 293;
    const DULMEN = 294;
    const ERISKAY = 295;
    const ESPERIA = 296;
    const EXMOOR = 297;
    const FAROE = 298;
    const FELL = 299;
    const FRENCH_PONY = 300;
    const GALICIAN_PONY = 301;
    const GARRANO = 302;
    const GAYOE = 303;
    const GERMAN_PONY = 304;
    const GOTLAND = 305;
    const GUIZHOU = 306;
    const HACKNEY_PONY = 307;
    const HOKKAIDO = 308;
    const HUCUL = 309;
    const INDIAN_COUNTRY = 310;
    const JAVA = 311;
    const KERRY_BOG = 312;
    const LANDAIS = 313;
    const LIJIANG = 314;
    const LUNDI = 315;
    const MANIPURI = 316;
    const MIYAKO = 317;
    const NARYM = 318;
    const NEW_FOREST = 319;
    const NEWFOUNDLAND = 320;
    const NOMA = 321;
    const NOOITGEDACHT = 322;
    const OB = 323;
    const PENEIA = 324;
    const PETISO = 325;
    const PINDOS = 326;
    const MOUSSEYE = 327;
    const PONY_AMERICAS = 328;
    const POTTOK = 329;
    const QUARTER_PONY = 330;
    const SABLE_ISLAND = 331;
    const SANDALWOOD = 332;
    const SHETLAND = 333;
    const SKYROS = 334;
    const SUMBA = 335;
    const TIBETAN = 336;
    const TIMOR = 337;
    const TOKARA = 338;
    const VYATKA = 339;
    const WELARA = 340;
    const WELSH_PONY = 341;
    const SUDAN = 342;
    const ZANISKARI = 343;
    const ZEMAITUKAS = 344;

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return int
     */
    public function gender();

    /**
     * @return int
     */
    public function breed();

    /**
     * @return string
     */
    public function height();

    /**
     * @return \Carbon\Carbon
     */
    public function dateOfBirth();

    /**
     * @return int
     */
    public function color();

    /**
     * @return string
     */
    public function lifeNumber();

    /**
     * @return \EQM\Models\HorseTeams\HorseTeam[]
     */
    public function userTeams();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function users();

    /**
     * @return \EQM\Models\Statuses\Status[]
     */
    public function statuses();

    /**
     * @return \EQM\Models\Pictures\Picture[]
     */
    public function pictures();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function followers();

    /**
     * @return \EQM\Models\Palmares\Palmares[]
     */
    public function palmares();

    /**
     * @return \EQM\Models\Pedigrees\Pedigree[]
     */
    public function pedigree();

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function family();

    /**
     * @return \EQM\Models\Disciplines\Discipline[]
     */
    public function disciplines();

    /**
     * @return \EQM\Models\Albums\Album[]
     */
    public function albums();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function father();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mother();

    /**
     * @return bool
     */
    public function hasFather();

    /**
     * @return bool
     */
    public function hasMother();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function fathersFather();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function fathersMother();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mothersFather();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mothersMother();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getProfilePicture();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getHeaderImage();

    /**
     * @return \Carbon\Carbon
     */
    public function getBirthDay();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function sons();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function daughters();

    /**
     * @param int $disciplineId
     * @return bool
     */
    public function performsDiscipline($disciplineId);

    /**
     * @return bool
     */
    public function isFemale();

    /**
     * @param int $type
     * @return \EQM\Models\Albums\Album
     */
    public function getStandardAlbum($type);
}
