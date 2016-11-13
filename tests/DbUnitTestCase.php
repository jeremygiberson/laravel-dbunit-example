<?php
namespace Laravel\DbUnit;

/**
 * Created by PhpStorm.
 * User: jeremygiberson
 * Date: 11/13/16
 * Time: 12:13 AM
 */
abstract class DbUnitTestCase extends \PHPUnit_Framework_TestCase
{
    use \PHPUnit_Extensions_Database_TestCase_Trait;

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        return $this->createDefaultDBConnection(\DB::connection()->getPdo(), env('DB_DATABASE'));
    }


    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        putenv('APP_ENV=testing');
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE='. __DIR__ . '/../test.sqlite');
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        \Artisan::call('migrate');
    }

    public static function tearDownAfterClass()
    {
        \Artisan::call('migrate:rollback');
        parent::tearDownAfterClass();
    }


}