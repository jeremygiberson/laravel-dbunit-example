<?php
/**
 * Created by PhpStorm.
 * User: jeremygiberson
 * Date: 11/13/16
 * Time: 1:01 AM
 */

namespace Laravel\DbUnit;


use Illuminate\Database\Eloquent\Factory;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DataSet_ITable;
use PHPUnit_Extensions_Database_DataSet_ITableIterator;
use PHPUnit_Extensions_Database_DataSet_ITableMetaData;
use Traversable;

class ModelFactoryDataset implements \PHPUnit_Extensions_Database_DataSet_IDataSet
{
    /**
     * @var \PHPUnit_Extensions_Database_DataSet_ArrayDataSet
     */
    protected $arrayDataSet;

    /**
     * ModelFactoryDataset constructor.
     */
    public function __construct(array $data)
    {
        $this->factory($data);
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->arrayDataSet->getIterator();
    }

    /**
     * Returns an array of table names contained in the dataset.
     *
     * @return array
     */
    public function getTableNames()
    {
        return $this->arrayDataSet->getTableNames();
    }

    /**
     * Returns a table meta data object for the given table.
     *
     * @param  string $tableName
     * @return PHPUnit_Extensions_Database_DataSet_ITableMetaData
     */
    public function getTableMetaData($tableName)
    {
        return $this->arrayDataSet->getTableMetaData($tableName);
    }

    /**
     * Returns a table object for the given table.
     *
     * @param  string $tableName
     * @return PHPUnit_Extensions_Database_DataSet_ITable
     */
    public function getTable($tableName)
    {
        return $this->arrayDataSet->getTable($tableName);
    }

    /**
     * Returns a reverse iterator for all table objects in the given dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_ITableIterator
     */
    public function getReverseIterator()
    {
        return $this->arrayDataSet->getReverseIterator();
    }

    /**
     * Asserts that the given data set matches this data set.
     *
     * @param PHPUnit_Extensions_Database_DataSet_IDataSet $other
     */
    public function matches(PHPUnit_Extensions_Database_DataSet_IDataSet $other)
    {
        return $this->arrayDataSet->matches($other);
    }

    private function factory(array $data)
    {
        $array = [];

        /** @var Factory $factory */
        $factory = app(Factory::class);
        foreach($data as $class => $rows) {
            $instance = new $class;
            $tableName = $instance->getTable();
            $array[$tableName] = [];

            foreach($rows as $row) {
                $array[$tableName][] = $factory->raw($class, $row);
            }
        }

        print_r($array);
        $this->arrayDataSet = new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet($array);
    }
}