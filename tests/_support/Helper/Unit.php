<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Lib\ModuleContainer;
use League\FactoryMuffin\Faker\Faker;

class Unit extends \Codeception\Module
{

    /** @var string */
    private $fixturesDir = '';

    /**
     * @var Faker
     */
    private $faker = null;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);

        $this->fixturesDir = codecept_root_dir('tests/_fixtures/');
        $faker = new Faker();
        $faker->setLocale('pl_PL');
        $this->faker = $faker->getGenerator();
    }

    /**
     * Returns Faker.
     *
     * @return \Faker\Generator
     */
    public function faker()
    {
        return $this->faker;
    }

    /**
     * Returns PHP file contents.
     *
     * @param  string $file
     * @return mixed
     */
    public function returnPhpFileFromFixture($file)
    {
        return require $this->fixturesDir . $file;
    }

    /**
     * Returns static file contents.
     *
     * @param  string $file
     * @return string
     */
    public function returnStaticFileFromFixture($file)
    {
        return file_get_contents($this->fixturesDir . $file);
    }
}
