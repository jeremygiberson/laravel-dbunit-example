# Using DbUnit in laravel tests

You'll need to install phpunit/dbunit `composer require --dev phpunit/dbunit`.

  * `DbUnitTestCase` is an abstract class that uses onBefore and onAfter events to setup the laravel application and run artisan migrate commands. It also sets some environment variables to make sure we use a test database connection.
  * `PatientsTest` and `AppointmentTest` are example tests that make use of dbunits provided ArrayData set to provide the initial dataset that tests run against.
  * `AppointmentAltTest` is a remake of `AppointmentTest` that utilizes `ModelFactoryDataset` to provide the test dataset. The benefit of `ModelFactoryDataset` is that you can make use of your configured model factories to generate most of the record set data and you only need to provide override values for columns you care about. That could be none of the columns or all depending on your testing needs. 
  * `ModelFactoryDatset` is a dataset implementation that will make use of configured model factories to populate row column data for you, but also gives you the opportunity to provide column data overrides. Construct the instance the same way you would an array data set where you pass an array where key is the model class name and value is an array of record arrays where each record is a key value array of column=>value. It's simplist usage might be `new ModelFactoryDataset([Patient::class => [[],[]]]);` which creates 2 patient records relying on model factory to populate all the column values for each record.
  * `App\Patient` and `App\Appointment` are just example models for the exercise
  * `database/factories/ModelFactory.php` configures model factories for Patient and Appointment models
 
