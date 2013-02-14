<?php

/**
 * @file
 * Definition of Drupal\system\Tests\PhpStorage\PhpStorageTestBase.
 */

namespace Drupal\system\Tests\PhpStorage;

use Drupal\simpletest\UnitTestBase;
use Drupal\Component\PhpStorage\PhpStorageFactory;

/**
 * Base test for PHP storage controllers.
 */
abstract class PhpStorageTestBase extends UnitTestBase {

  /**
   * The storage factory object.
   *
   * @var \Drupal\Component\PhpStorage\PhpStorageFactory
   */
  protected $storageFactory;

  /**
   * Overrides \Drupal\simpletest\UnitTestBase::setUp()
   */
  function setUp() {
    parent::setUp();
    $this->storageFactory = new PhpStorageFactory;
  }

  /**
   * Assert that a PHP storage controller's load/save/delete operations work.
   */
  public function assertCRUD($php) {
    $name = $this->randomName() . '/' . $this->randomName() . '.php';

    // Find a global that doesn't exist.
    do {
      $random = mt_rand(10000, 100000);
    } while (isset($GLOBALS[$random]));

    // Write out a PHP file and ensure it's successfully loaded.
    $code = "<?php\n\$GLOBALS[$random] = TRUE;";
    $success = $php->save($name, $code);
    $this->assertIdentical($success, TRUE);
    $php->load($name);
    $this->assertTrue($GLOBALS[$random]);

    // If the file was successfully loaded, it must also exist, but ensure the
    // exists() method returns that correctly.
    $this->assertIdentical($php->exists($name), TRUE);

    // Delete the file, and then ensure exists() returns FALSE.
    $success = $php->delete($name);
    $this->assertIdentical($success, TRUE);
    $this->assertIdentical($php->exists($name), FALSE);

    // Ensure delete() can be called on a non-existing file. It should return
    // FALSE, but not trigger errors.
    $this->assertIdentical($php->delete($name), FALSE);
  }
}
