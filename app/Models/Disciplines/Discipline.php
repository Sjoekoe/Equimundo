<?php
namespace EQM\Models\Disciplines;

interface Discipline
{
    const BANEI = 1;
    const CAMARGUE = 2;
    const CHARRERIA = 3;
    const COLEO_DE_TOROS = 4;
    const DOMA_VAQUERA = 5;
    const DZHIGITOVKA = 6;
    const EQUITATION = 7;
    const GYMKHANA = 8;
    const HORSE_SHOW = 9;
    const ORIENTEERING = 10;
    const PLEASURE = 11;
    const PONY_CLUB = 12;
    const SIDESADDLE = 13;
    const TRAIL_RIDING = 14;
    const WORKING_EQUITATION = 15;
    const CORRIDA_DE_SORTIJA = 16;
    const JINETAEDA = 17;
    const DEPORTE_DE_LAZO = 18;
    const ICELANDIC = 19;
    const DOMA_MENORQUINA = 20;
    const FLAT_RACING = 21;
    const HARNESS_RACING = 22;
    const POINT_TO_POINT = 23;
    const STEEPLECHASE = 24;
    const THOROUGHBRED_RACING = 25;
    const CLASSICAL_DRESSAGE = 26;
    const DRESSAGE = 27;
    const ENGLISH_PLEASURE = 28;
    const EVENTING = 29;
    const FIELD_HUNTER = 30;
    const FOX_HUNTING = 31;
    const HUNT_SEAT = 32;
    const SADDLE_SEAT = 33;
    const SHOW_HUNTER = 34;
    const SHOW_JUMPING = 35;
    const SHOW_HACK = 36;
    const TEAM_CHASING = 37;
    const QUADRILLE = 38;
    const MOUNTED_SHOOTING = 39;
    const COWBOY_POLO = 40;
    const O_MOK_SEE = 41;
    const REINING = 42;
    const TRAIL = 43;
    const WESTERN_PlEASURE = 44;
    const WESTERN = 45;
    const CAMPDRAFTING = 46;
    const CUTTING = 47;
    const RANCH_SORTING = 48;
    const TEAM_PENNING = 49;
    const WORKING_COW = 50;
    const AUSTRAILIAN_RODEO = 51;
    const BARREL_RACING = 52;
    const BREAKAWAY_ROPING = 53;
    const CALF_ROPING = 54;
    const CHARREADA = 55;
    const CHILEAN_RODEO = 56;
    const GOAT_TYING = 57;
    const POLE_BENDING = 58;
    const SADDLE_BRONC = 59;
    const STEER_WRESTLING = 60;
    const TEAM_ROPING = 61;
    const COMBINED_DRIVING = 62;
    const DRAFT_HORSE = 63;
    const FINE_HARNESS = 64;
    const PLEASURE_DRIVING = 65;
    const ROADSTER = 66;
    const SCURRY_DRIVING = 67;
    const HORSEBALL = 68;
    const PATO = 69;
    const POLO = 70;
    const POLOCROSSE = 71;
    const BUZKASHI = 72;
    const JOUSTING = 73;
    const MOUNTED_ARCHERY = 74;
    const MOUNTED_GAMES = 75;
    const TENT_PEGGING = 76;

    const VARIOUS = [
        self::BANEI ,
        self::CAMARGUE ,
        self::CHARRERIA ,
        self::COLEO_DE_TOROS ,
        self::DOMA_VAQUERA ,
        self::DZHIGITOVKA ,
        self::EQUITATION ,
        self::HORSE_SHOW ,
        self::ORIENTEERING ,
        self::PLEASURE ,
        self::PONY_CLUB ,
        self::SIDESADDLE ,
        self::TRAIL_RIDING ,
        self::WORKING_EQUITATION ,
        self::CORRIDA_DE_SORTIJA ,
        self::JINETAEDA ,
        self::DEPORTE_DE_LAZO ,
        self::ICELANDIC ,
        self::DOMA_MENORQUINA ,
    ];

    const RACING = [
        self::FLAT_RACING ,
        self::HARNESS_RACING ,
        self::POINT_TO_POINT ,
        self::STEEPLECHASE ,
        self::THOROUGHBRED_RACING ,
    ];

    const CLASSIC = [
        self::CLASSICAL_DRESSAGE ,
        self::DRESSAGE ,
        self::ENGLISH_PLEASURE ,
        self::EVENTING ,
        self::FIELD_HUNTER ,
        self::FOX_HUNTING ,
        self::GYMKHANA ,
        self::HUNT_SEAT ,
        self::SADDLE_SEAT ,
        self::SHOW_HUNTER ,
        self::SHOW_JUMPING ,
        self::SHOW_HACK ,
        self::TEAM_CHASING ,
        self::QUADRILLE ,
    ];

    const WESTERN_SPORTS = [
        self::MOUNTED_SHOOTING ,
        self::COWBOY_POLO ,
        self::O_MOK_SEE ,
        self::REINING ,
        self::TRAIL ,
        self::WESTERN_PlEASURE ,
        self::WESTERN ,
        self::CAMPDRAFTING ,
        self::CUTTING ,
        self::RANCH_SORTING ,
        self::TEAM_PENNING ,
        self::WORKING_COW ,
        self::AUSTRAILIAN_RODEO ,
        self::BARREL_RACING ,
        self::BREAKAWAY_ROPING ,
        self::CALF_ROPING ,
        self::CHARREADA ,
        self::CHILEAN_RODEO ,
        self::GOAT_TYING ,
        self::POLE_BENDING ,
        self::SADDLE_BRONC ,
        self::STEER_WRESTLING ,
        self::TEAM_ROPING ,
    ];

    const HARNESS = [
        self::COMBINED_DRIVING ,
        self::DRAFT_HORSE ,
        self::FINE_HARNESS ,
        self::PLEASURE_DRIVING ,
        self::ROADSTER ,
        self::SCURRY_DRIVING ,
    ];

    const TEAM = [
        self::HORSEBALL,
        self::PATO,
        self::POLO,
        self::POLOCROSSE,
    ];

    const ANCIENT = [
        self::BUZKASHI,
        self::JOUSTING,
        self::MOUNTED_ARCHERY,
        self::MOUNTED_GAMES,
        self::TENT_PEGGING,
    ];

    /**
     * @return int
     */
    public function id();

    /**
     * @return int
     */
    public function discipline();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return \DateTime
     */
    public function createdAt();

    /**
     * @return \DateTime
     */
    public function updatedAt();
}
