<?php

/**
 * @file
 * Contains Drupal\system\Tests\Upgrade\DateUpgradePathTest.
 */

namespace Drupal\system\Tests\Upgrade;

/**
 * Test upgrade of date formats.
 */
class DateUpgradePathTest extends UpgradePathTestBase {
  public static function getInfo() {
    return array(
      'name' => 'Date upgrade test',
      'description' => 'Upgrade tests for date formats.',
      'group' => 'Upgrade path',
    );
  }

  public function setUp() {
    $this->databaseDumpFiles = array(
      drupal_get_path('module', 'system') . '/tests/upgrade/drupal-7.bare.standard_all.database.php.gz',
      drupal_get_path('module', 'system') . '/tests/upgrade/drupal-7.date.database.php',
    );
    parent::setUp();
  }

  /**
   * Tests that date formats have been upgraded.
   */
  public function testDateUpgrade() {
    $this->assertTrue($this->performUpgrade(), 'The upgrade was completed successfully.');

    // Verify standard date formats.
    $expected_formats['short'] = array(
      'name' => 'Short',
      'pattern' => array(
        'php' => 'Y/m/d - H:i',
      ),
      'locked' => '1',
    );
    $expected_formats['medium'] = array(
      'name' => 'Medium',
      'pattern' => array(
        'php' => 'D, d/m/Y - H:i',
      ),
      'locked' => '1',
    );
    $expected_formats['long'] = array(
      'name' => 'Long',
      'pattern' => array(
        'php' => 'l, Y,  F j - H:i',
      ),
      'locked' => '1',
    );

    // Verify custom date format.
    $expected_formats['test_custom'] = array(
      'name' => 'Test Custom',
      'pattern' => array(
        'php' => 'd m Y',
        ),
      'locked' => '0',
    );

    foreach ($expected_formats as $type => $format) {
      $format_info = config('system.date')->get('formats.' . $type);

      $this->assertEqual($format_info['name'], $format['name'], format_string('Config value for @type name is the same', array('@type' => $type)));
      $this->assertEqual($format_info['locked'], $format['locked'], format_string('Config value for @type locked is the same', array('@type' => $type)));
      $this->assertEqual($format_info['pattern']['php'], $format['pattern']['php'], format_string('Config value for @type PHP date pattern is the same', array('@type' => $type)));

      // Make sure that the variable was deleted.
      $this->assertNull(update_variable_get('date_format_' . $type), format_string('Date format variable for @type was deleted.', array('@type' => $type)));
    }

    $expected_locale_formats = array(
      array(
        'langcode' => 'en',
        'type' => 'long',
        'format' => 'l, j F, Y - H:i',
      ),
      array(
        'langcode' => 'en',
        'type' => 'medium',
        'format' => 'D, m/d/Y - H:i',
      ),
      array(
        'langcode' => 'en',
        'type' => 'short',
        'format' => 'm/d/Y - H:i',
      ),
      array(
        'langcode' => 'de',
        'type' => 'long',
        'format' => 'l, j. F, Y - H:i',
      ),
      array(
        'langcode' => 'de',
        'type' => 'medium',
        'format' => 'D, d/m/Y - H:i',
      ),
      array(
        'langcode' => 'de',
        'type' => 'short',
        'format' => 'd/m/Y - H:i',
      ),
    );

    $config['en'] = config('locale.config.en.system.date');
    $config['de'] = config('locale.config.de.system.date');
    foreach ($expected_locale_formats as $locale_format) {
      $format = $config[$locale_format['langcode']]->get('formats.' . $locale_format['type'] . '.pattern.php');
      $this->assertEqual($locale_format['format'], $format);
    }
  }
}
