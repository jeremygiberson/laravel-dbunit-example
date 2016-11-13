<?php
/**
 * Created by PhpStorm.
 * User: jeremygiberson
 * Date: 11/13/16
 * Time: 1:13 AM
 */

namespace Laravel\DbUnit;


use App\Appointment;
use PHPUnit_Extensions_Database_DataSet_IDataSet;

class AppointmentAltTest extends DbUnitTestCase
{

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new ModelFactoryDataset([
            Appointment::class => [
                ['appointment_date' => date('Y-m-d', strtotime('+1 week')), 'status' => Appointment::STATUS_SCHEDULED],
                ['appointment_date' => date('Y-m-d', strtotime('-1 week')), 'status' => Appointment::STATUS_CANCELED],
                ['appointment_date' => date('Y-m-d', strtotime('-2 week')), 'status' => Appointment::STATUS_COMPLETE],
                ['appointment_date' => date('Y-m-d', strtotime('-3 week')), 'status' => Appointment::STATUS_NOSHOW],
            ]
        ]);
    }

    public function testScopeNoShows()
    {
        $noShows = Appointment::noShows()->get();
        self::assertCount(1, $noShows);
        self::assertEquals(Appointment::STATUS_NOSHOW, $noShows[0]->status);
    }

    public function testScopeCancelled()
    {
        $canceled = Appointment::canceled()->get();
        self::assertCount(1, $canceled);
        self::assertEquals(Appointment::STATUS_CANCELED, $canceled[0]->status);
    }

    public function testAppointmentCount()
    {
        self::assertCount(4, Appointment::all());
    }
}