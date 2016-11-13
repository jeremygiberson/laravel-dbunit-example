<?php
namespace Laravel\DbUnit;

use App\Patient;

/**
 * Created by PhpStorm.
 * User: jeremygiberson
 * Date: 11/13/16
 * Time: 12:24 AM
 */
class PatientsTest extends DbUnitTestCase
{

    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'patients' => [
                ['id' => 1, 'name' => 'Bobby Patient', 'date_of_birth' => date('Y-m-d', strtotime('1992-03-21')), 'created_at' => date('Y-m-d', strtotime('-1 month')), 'updated_at' => date('Y-m-d', strtotime('-1 week'))],
                ['id' => 2, 'name' => 'Susie Patient', 'date_of_birth' => date('Y-m-d', strtotime('1993-02-11')), 'created_at' => date('Y-m-d', strtotime('-7 month')), 'updated_at' => date('Y-m-d', strtotime('-4 month'))],
            ]
        ]);
    }

    public function testScopeNewPatients()
    {
        $newPatients = Patient::newPatients()->get();
        self::assertCount(1, $newPatients);
        self::assertEquals(1, $newPatients[0]->id);
    }

    public function testScopeExistingPatients()
    {
        $newPatients = Patient::existingPatients()->get();
        self::assertCount(1, $newPatients);
        self::assertEquals(2, $newPatients[0]->id);
    }
}