<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Region Entity
 *
 * @property int $id
 * @property string $name
 *
 * @property \App\Model\Entity\CaseByRegion[] $case_by_region
 * @property \App\Model\Entity\CovidPl[] $covid_pl
 * @property \App\Model\Entity\CovidPl2[] $covid_pl2
 * @property \App\Model\Entity\TmpCovidPl[] $tmp_covid_pl
 * @property \App\Model\Entity\TmpCovidPl2[] $tmp_covid_pl2
 * @property \App\Model\Entity\TmpDeath[] $tmp_death
 * @property \App\Model\Entity\TmpInfected[] $tmp_infected
 */
class Region extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'case_by_region' => true,
        'covid_pl' => true,
        'covid_pl2' => true,
        'tmp_covid_pl' => true,
        'tmp_covid_pl2' => true,
        'tmp_death' => true,
        'tmp_infected' => true,
    ];
}
