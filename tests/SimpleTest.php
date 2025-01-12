<?php
/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @category Tools
 * @package  JsonMapper
 * @author   Christian Weiske <cweiske@cweiske.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 */
require_once 'JsonMapperTest/Simple.php';
require_once 'JsonMapperTest/ArrayValueForStringProperty.php';

/**
 * Unit tests for JsonMapper's simple type handling
 *
 * @category Tools
 * @package  JsonMapper
 * @author   Christian Weiske <cweiske@cweiske.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 */
class SimpleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for "@var string"
     */
    public function testMapSimpleString()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"str":"stringvalue"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->str);
        $this->assertEquals('stringvalue', $sn->str);
    }

    /**
     * Test for "@var float"
     */
    public function testMapSimpleFloat()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"fl":"1.2"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsFloat($sn->fl);
        $this->assertEquals(1.2, $sn->fl);
    }

    /**
     * Test for "@var bool"
     */
    public function testMapSimpleBool()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pbool":"1"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsBool($sn->pbool);
        $this->assertEquals(true, $sn->pbool);
    }

    /**
     * Test for "@var boolean"
     */
    public function testMapSimpleBoolean()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pboolean":"0"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsBool($sn->pboolean);
        $this->assertEquals(false, $sn->pboolean);
    }

    /**
     * Test for "@var int"
     */
    public function testMapSimpleInt()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pint":"123"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsInt($sn->pint);
        $this->assertEquals(123, $sn->pint);
    }

    /**
     * Test for "@var integer"
     */
    public function testMapSimpleInteger()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pinteger":"12345"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsInt($sn->pinteger);
        $this->assertEquals(12345, $sn->pinteger);
    }

    /**
     * Test for "@var mixed"
     */
    public function testMapSimpleMixed()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"mixed":12345}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsInt($sn->mixed);
        $this->assertEquals('12345', $sn->mixed);

        $sn = $jm->map(
            json_decode('{"mixed":"12345"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->mixed);
        $this->assertEquals(12345, $sn->mixed);
    }

    /**
     * Test for "@var int|null" with int value
     */
    public function testMapSimpleNullableInt()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pnullable":0}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsInt($sn->pnullable);
        $this->assertEquals(0, $sn->pnullable);
    }

    /**
     * Test for "@var int|null" with null value
     */
    public function testMapSimpleNullableNull()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pnullable":null}'),
            new JsonMapperTest_Simple()
        );
        $this->assertNull($sn->pnullable);
        $this->assertEquals(null, $sn->pnullable);
    }

    /**
     * Test for "@var int|null" with string value
     */
    public function testMapSimpleNullableWrong()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"pnullable":"12345"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsInt($sn->pnullable);
        $this->assertEquals(12345, $sn->pnullable);
    }

    /**
     * Test for variable with no @var annotation
     */
    public function testMapSimpleNoType()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"notype":{"k":"v"}}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsObject($sn->notype);
        $this->assertEquals((object) array('k' => 'v'), $sn->notype);
    }

    /**
     * Variable with an underscore
     */
    public function testMapSimpleUnderscore()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"under_score":"f"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->under_score);
        $this->assertEquals('f', $sn->under_score);
    }


    /**
     * Variable with an underscore and a setter method
     */
    public function testMapSimpleUnderscoreSetter()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"under_score_setter":"blubb"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->internalData['under_score_setter']);
        $this->assertEquals(
            'blubb', $sn->internalData['under_score_setter']
        );
    }

    /**
     * Variable with hyphen (-)
     */
    public function testMapSimpleHyphen()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"hyphen-value":"test"}'),
            new JsonMapperTest_Simple()
        );

        $this->assertIsString($sn->hyphenValue);
        $this->assertEquals('test', $sn->hyphenValue);

    }

    /**
     * Variable with hyphen and a setter method
     */
    public function testMapSimpleHyphenSetter()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"hyphen-value-setter":"blubb"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->internalData['hyphen-value-setter']);
        $this->assertEquals(
            'blubb', $sn->internalData['hyphen-value-setter']
        );

    }

    public function testMapArrayValueToStringProperty()
    {
        $jm = new JsonMapper();
        $this->expectException(JsonMapper_Exception::class);
        $this->expectExceptionMessage('JSON property "value" in class "JsonMapperTest_ArrayValueForStringProperty" is of type array and cannot be converted to string');
        $jm->map(
            json_decode('{"value":[]}'),
            new JsonMapperTest_ArrayValueForStringProperty()
        );
    }

    /**
     * Variable has no docblock, and has different caSiNg than object property
     */
    public function testMapCaseMismatchNoDocblock()
    {
        $jm = new JsonMapper();
        $sn = $jm->map(
            json_decode('{"noDocBlock":"blubb"}'),
            new JsonMapperTest_Simple()
        );
        $this->assertIsString($sn->nodocblock);
        $this->assertEquals('blubb', $sn->nodocblock);
    }
}
?>
