<?php
namespace Laravel\DbUnit;

use App\Appointment;
use App\Patient;
use PHPUnit_Extensions_Database_DataSet_IDataSet;

/**
 * Created by PhpStorm.
 * User: jeremygiberson
 * Date: 11/13/16
 * Time: 12:45 AM
 */
class AppointmentTest extends DbUnitTestCase
{

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'appointments' => [
                ['id' => 1, 'patient_id' => 1, 'appointment_date' => date('Y-m-d', strtotime('+1 week')), 'status' => Appointment::STATUS_SCHEDULED],
                ['id' => 2, 'patient_id' => 1, 'appointment_date' => date('Y-m-d', strtotime('-1 week')), 'status' => Appointment::STATUS_CANCELED],
                ['id' => 3, 'patient_id' => 1, 'appointment_date' => date('Y-m-d', strtotime('-2 week')), 'status' => Appointment::STATUS_COMPLETE],
                ['id' => 4, 'patient_id' => 1, 'appointment_date' => date('Y-m-d', strtotime('-3 week')), 'status' => Appointment::STATUS_NOSHOW],
            ]
        ]);
    }

    public function testScopeNoShows()
    {
        $noShows = Appointment::noShows()->get();
        self::assertCount(1, $noShows);
        self::assertEquals(4, $noShows[0]->id);
    }

    public function testScopeCancelled()
    {
        $canceled = Appointment::canceled()->get();
        self::assertCount(1, $canceled);
        self::assertEquals(2, $canceled[0]->id);
    }

    public function testEmptyPatients()
    {
        self::assertCount(0, Patient::all());
    }
}