<?php

use Skynet\DiscoverableBucketTweak;
use Skynet\Uint8Array;
use function Skynet\functions\strings\hexToUint8Array;
use function Skynet\functions\tweak\deriveDiscoverableFileTweak;
use function Skynet\functions\tweak\hashPathComponent;
/**
 * @group functions
 */
class tweakTest extends \Codeception\Test\Unit {

	private $fullPath = 'skyfeed.hns/preferences/ui.json';
	private $paths = [ 'skyfeed.hns', 'preferences', 'ui.json' ];

	public function testPathHashes() {
		$pathHashes = [

			[
				$this->paths[0],
				[
					51,
					167,
					30,
					159,
					125,
					56,
					105,
					160,
					29,
					147,
					178,
					185,
					97,
					129,
					100,
					44,
					39,
					130,
					248,
					221,
					74,
					202,
					53,
					40,
					86,
					42,
					24,
					19,
					74,
					16,
					179,
					193,
				],
			],
			[
				$this->paths[1],
				[
					49,
					88,
					82,
					205,
					55,
					45,
					202,
					7,
					157,
					7,
					173,
					166,
					123,
					131,
					10,
					196,
					194,
					13,
					141,
					206,
					37,
					91,
					4,
					190,
					100,
					191,
					107,
					123,
					214,
					6,
					160,
					221,
				],
			],
			[
				$this->paths[2],
				[
					46,
					4,
					188,
					144,
					182,
					185,
					156,
					100,
					51,
					181,
					155,
					119,
					152,
					105,
					130,
					186,
					253,
					138,
					155,
					18,
					98,
					173,
					11,
					70,
					41,
					138,
					162,
					119,
					46,
					113,
					68,
					59,
				],
			],
		];

		foreach ( $pathHashes as $pathHash ) {
			$recievedHash = hashPathComponent( $pathHash[0] );
			expect( $recievedHash->compare( Uint8Array::from( $pathHash[1] ) ) )->toBeTrue();
		}

	}

	public function testDeriveDiscoverableTweak_ShouldCorrectlyDeriveTheDbt() {
		$dataKey = deriveDiscoverableFileTweak( $this->fullPath );
		$tweak = hexToUint8Array( $dataKey );
		$expectedDbt = [
			196,
			18,
			90,
			152,
			134,
			166,
			231,
			11,
			39,
			197,
			25,
			28,
			19,
			221,
			214,
			197,
			216,
			8,
			7,
			142,
			230,
			239,
			128,
			193,
			47,
			26,
			48,
			226,
			142,
			150,
			72,
			225,
		];


		expect( $tweak->compare( Uint8Array::from( $expectedDbt ) ) )->toBeTrue();
	}

	public function testFullyEncodedDBT_ShouldCorrectlyEncodeTheDbt() {
		$expectedEncoding = [
			1,
			51,
			167,
			30,
			159,
			125,
			56,
			105,
			160,
			29,
			147,
			178,
			185,
			97,
			129,
			100,
			44,
			39,
			130,
			248,
			221,
			74,
			202,
			53,
			40,
			86,
			42,
			24,
			19,
			74,
			16,
			179,
			193,
			49,
			88,
			82,
			205,
			55,
			45,
			202,
			7,
			157,
			7,
			173,
			166,
			123,
			131,
			10,
			196,
			194,
			13,
			141,
			206,
			37,
			91,
			4,
			190,
			100,
			191,
			107,
			123,
			214,
			6,
			160,
			221,
			46,
			4,
			188,
			144,
			182,
			185,
			156,
			100,
			51,
			181,
			155,
			119,
			152,
			105,
			130,
			186,
			253,
			138,
			155,
			18,
			98,
			173,
			11,
			70,
			41,
			138,
			162,
			119,
			46,
			113,
			68,
			59,
		];
		$dbt              = new DiscoverableBucketTweak( $this->fullPath );
		$encoding         = $dbt->encode();
		expect( Uint8Array::from( $expectedEncoding )->compare( $encoding ) );
	}
}