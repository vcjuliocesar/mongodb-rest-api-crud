<?php

use CodeIgniter\Test\CIUnitTestCase;
use Tests\Support\Database\Seeds\ExampleSeeder;
use Tests\Support\Models\ExampleModel;

/**
 * @internal
 */
final class ExampleDatabaseTest extends CIUnitTestCase
{
    //use DatabaseTestTrait;
    protected $seed;

    public function testModelFindAll()
    {
        (new ExampleSeeder)->run();
        $model = new ExampleModel();
        // Get every row created by ExampleSeeder
        $objects = $model->getCollection()->find();
        // Make sure the count is as expected
        $this->assertCount(3, $objects);
    }

    public function testSoftDeleteLeavesRow()
    {
        (new ExampleSeeder)->run();
        $model = new ExampleModel();

        $object = $model->getCollection()->findOne();
        $model->getCollection()->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($object->_id)]);

        // The model should no longer find it
        $this->assertNull($model->getCollection()->findOne(['_id'=> new \MongoDB\BSON\ObjectId($object->_id)]));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Do something here....
        $model = new ExampleModel();
        $model->deleteCollection();
        //(new TestMongoDb())->tearDown();
    }
}
