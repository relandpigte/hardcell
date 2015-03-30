<?php
require_once( pb_backupbuddy::plugin_path() . '/classes/core.php' );


class backupbuddy_remote_api {
	
	private static $_errors = array();		// Hold error strings to retrieve with getErrors().
	
	public static function localCall( $secure = false, $importbuddy = false ) {
		if ( true !== $secure ) {
			die( '<html>403 Access Denied</html>' );
		}
		
		if ( true !== self::is_call_valid() ) {
			$message = 'Error #8483974: Error validating API call authenticity.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		}
		
		// If here then validation was all good. API call is authorized.
		
		if ( true !== $importbuddy ) {
			$functionName = '_verb_' . pb_backupbuddy::_POST( 'verb' );
		} else {
			$functionName = '_verb_importbuddy_' . pb_backupbuddy::_POST( 'verb' );
		}
		
		// Does verb exist?
		if ( false === method_exists( 'backupbuddy_remote_api', $functionName ) ) {
			$message = 'Error #843489974: Unknown verb `' . pb_backupbuddy::_POST( 'verb' ) . '`.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		} else {
			call_user_func_array( 'backupbuddy_remote_api::' . $functionName, array() );
		}
		
		// function: verb_[VERBHERE]
	}
	
	
	
	/* remoteCall()
	 *
	 * Send an API call to a remote server.
	 *
	 */
	public static function remoteCall( $remoteAPI, $verb, $moreParams = array(), $timeout = '', $file = '', $fileData = '', $seekTo = '', $isFileTest = '', $isFileDone = false, $fileSize = '' ) {
		pb_backupbuddy::status( 'details', 'Preparing remote API call.' );
		$now = time();
		
		$body = array(
			'backupbuddy_api_key' => $remoteAPI['key_public'],
			'backupbuddy_version' => pb_backupbuddy::settings( 'version' ),
			'verb' => $verb,
			'now' => $now,
		);
		
		if ( '' == $timeout ) {
			$timeout = $remoteAPI['max_time'];
		}
		pb_backupbuddy::status( 'details', 'remoteCall() HTTP wait timeout: `' . $timeout . '` seconds.' );
		
		$filecrc = '';
		if ( '' != $file ) {
			pb_backupbuddy::status( 'details', 'Remote API sending file `' . $file . '`.' );
			$fileData = base64_encode( $fileData ); // Sadly we cannot safely transmit binary data over curl without using an actual file. base64 encoding adds 37% size overhead.
			$filecrc = sprintf ( "%u", crc32( $fileData ) );
			$body['filename'] = basename( $file );
			$body['filedata'] = $fileData;
			$body['filedatalen'] = strlen( $fileData );
			$body['filecrc'] = $filecrc;
			if ( true === $isFileTest ) {
				$body['filetest'] = '1';
			} else {
				$body['filetest'] = '0';
			}
			if ( true === $isFileDone ) {
				$body['filedone'] = '1';
			} else {
				$body['filedone'] = '0';
			}
			$body['seekto'] = $seekTo; // Location to seek to before writing this part.
			if ( '' != $fileSize ) {
				$body['filetotalsize'] = $fileSize;
			}
		}
		$body = array_merge( $body, $moreParams );
		
		//print_r( $apiKey );
		$body['signature'] = md5( $now . $verb . $remoteAPI['key_public'] . $remoteAPI['key_secret'] . $filecrc );
		
		if ( defined( 'BACKUPBUDDY_DEV' ) && ( true === BACKUPBUDDY_DEV ) ) {
			error_log( 'BACKUPBUDDY_DEV-remote api http body SEND- ' . print_r( $body, true ) );
		}
		
		$response = wp_remote_post( $remoteAPI['siteurl'], array(
				'method' => 'POST',
				'timeout' => $timeout,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => $body,
				'cookies' => array()
			)
		);
		if ( is_wp_error( $response ) ) {
			return self::_error( 'Error #8447755: ' . $response->get_error_message() . ' - URL: `' . $remoteAPI['siteurl'] . '`.' );
		} else {
			if ( null === ( $return = json_decode( $response['body'], true ) ) ) {
				return self::_error( 'Error #4543664: Unable to decode json response. Verify remote site API URL, API key, and that the remote site has the API enabled. Return data: `' . htmlentities( $response['body'] ) . '`.' );
			} else {
				if ( true !== $return['success'] ) {
					return self::_error( 'Error #3289379: API did not report success. Details: `' . $return['error'] . '`.' );
				} else {
					if ( isset( $return['message'] ) ) {
						pb_backupbuddy::status( 'details', 'Response message from API:' . $return['message'] . '".' );
					}
					return $return;
				}
			}
		}
	} // End remoteCall().
	
	
	
	private static function _verb_sendFile() {
		
		$tempDir = backupbuddy_core::getTempDirectory();
		pb_backupbuddy::anti_directory_browsing( $tempDir, $die = false );
		
		// Open/create file for write/append.
		$saveFile = $tempDir . str_replace( array( '\\', '/' ), '', pb_backupbuddy::_POST( 'filename' ) );
		if ( false === ( $fs = fopen( $saveFile, 'c' ) )) {
			$message = 'Error #489339848: Unable to fopen file `' . $saveFile . '`.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		}
		
		// Seek to position (if applicable).
		if ( 0 != fseek( $fs, pb_backupbuddy::_POST( 'seekto' ) ) ) {
			@fclose( $fs );
			$message = 'Error #8584884: Unable to fseek file.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		}
		
		// Check data length.
		$gotLength = strlen( pb_backupbuddy::_POST( 'filedata' ) );
		if ( pb_backupbuddy::_POST( 'filedatalen' ) != $gotLength ) {
			@fclose( $fs );
			$message = 'Error #4355445: Received data of length `' . $gotLength . '` did not match sent length of `' . pb_backupbuddy::_POST( 'filedatalen' ) . '`. Data may have been truncated.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		}
		
		// Check hash.
		if ( pb_backupbuddy::_POST( 'filecrc' ) != sprintf ( "%u", crc32( pb_backupbuddy::_POST( 'filedata' ) ) ) ) {
			@fclose( $fs );
			$message = 'Error #473472: CRC of received data did not match source CRC. Data corrupted in transfer? Sent length: `' . pb_backupbuddy::_POST( 'filedatalen' ) . '`. Received length: `' . $gotLength . '`.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		}
		
		// Write to file.
		if ( false === ( $bytesWritten = fwrite( $fs, base64_decode( pb_backupbuddy::_POST( 'filedata' ) ) ) ) ) {
			@fclose( $fs );
			@unlink( $saveFile );
			$message = 'Error #3984394: Error writing to file `' . $saveFile . '`.';
			pb_backupbuddy::status( 'error', $message );
			die( json_encode( array( 'success' => false, 'error' => $message ) ) );
		} else {
			@fclose( $fs );
			
			$message = 'Wrote `' . $bytesWritten . '` bytes.';
			pb_backupbuddy::status( 'details', $message );
			
			if ( '1' == pb_backupbuddy::_POST( 'filetest' ) ) {
				@unlink( $saveFile );
			} else {
				if ( '1' == pb_backupbuddy::_POST( 'filedone' ) ) {
					$destFile = ABSPATH . basename( $saveFile );
					/*
					if ( false === @copy( $saveFile, $destFile ) ) {
						pb_backupbuddy::status( 'error', 'Error #948454: Unable to copy temporary file `' . $saveFile . '` to `' . $destFile . '`.' );
					}
					@unlink( $saveFile );
					*/
					die( json_encode( array( 'success' => true, 'message' => $message ) ) );
				}
			}
			
			die( json_encode( array( 'success' => true, 'message' => $message ) ) );
		}
		
	} // End _verb_sendFile().
	
	
	
	private static function _verb_getPreDeployInfo() {
		die( json_encode( array( 'success' => true, 'data' => backupbuddy_api::getPreDeployInfo() ) ) );
	} // End _verb_getPreDeployInfo().
	
	
	private static function _verb_renderImportBuddy() {
		
		$tempDir = backupbuddy_core::getTempDirectory();
		$tempFile = $tempDir . str_replace( array( '\\', '/' ), '', pb_backupbuddy::_POST( 'backupFile' ) );
		if ( ! file_exists( $tempFile ) ) {
			die( json_encode( array( 'success' => false, 'error' => 'Error #43848378: Backup file `' . $tempFile . '` not found uploaded.' ) ) );
		}
		
		$importFileSerial = pb_backupbuddy::random_string( 15 );
		$importFilename = 'importbuddy-' . $importFileSerial . '.php';
		backupbuddy_core::importbuddy( ABSPATH . $importFilename, $password = md5( md5( pb_backupbuddy::_POST( 'backupbuddy_api_key' ) ) ) );
		
		// Render default config file overrides. Overrrides default restore.php state data.
		$state = array();
		global $wpdb;
		$state['type'] = 'deploy';
		$state['archive'] = $tempDir . pb_backupbuddy::_POST( 'backupFile' );
		$state['siteurl'] = site_url();
		$state['homeurl'] = home_url();
		$state['restoreFiles'] = false;
		$state['migrateHtaccess'] = false;
		$state['remote_api'] = pb_backupbuddy::$options['remote_api']; // For use by importbuddy api auth. Enables remote api in this importbuddy.
		$state['databaseSettings']['server'] = DB_HOST;
		$state['databaseSettings']['database'] = DB_NAME;
		$state['databaseSettings']['username'] = DB_USER;
		$state['databaseSettings']['password'] = DB_PASSWORD;
		$state['databaseSettings']['prefix'] = $wpdb->prefix;
		$state['databaseSettings']['renamePrefix'] = true;
		
		// Write default state overrides.
		$state_file = ABSPATH . 'importbuddy-' . $importFileSerial . '-state.php';
		if ( false === ( $file_handle = @fopen( $state_file, 'w' ) ) ) {
			pb_backupbuddy::status( 'error', 'Error #8384784: Temp state file is not creatable/writable. Check your permissions. (' . $state_file . ')' );
			return false;
		}
		fwrite( $file_handle, "<?php die('Access Denied.'); // <!-- ?>\n" . base64_encode( serialize( $state ) ) );
		fclose( $file_handle );
		
		die( json_encode( array( 'success' => true, 'importFileSerial' => $importFileSerial ) ) );
		
	} // End _verb_renderImportBuddy().
	
	
	public static function is_call_valid() {
		$key_public = pb_backupbuddy::_POST('backupbuddy_api_key');
		$verb = pb_backupbuddy::_POST('verb');
		$time = pb_backupbuddy::_POST('now');
		$filecrc = pb_backupbuddy::_POST('filecrc');
		$signature = pb_backupbuddy::_POST('signature');
		
		$maxAge = 60*60; // Time in seconds after which a signed request is deemed too old. Help prevent replays. 1hr.
		foreach( pb_backupbuddy::$options['remote_api']['keys'] as $key ) {
			$keyArr = self::key_to_array( $key );
			if ( $key_public == $keyArr['key_public'] ) { // Incoming public key matches a stored public key.
				// Has call expired?
				if ( ( ! is_numeric( $time ) ) || ( ( time() - $time ) > $maxAge ) ) {
					$message = 'Error #4845985: API call timestamp is too old. Verify the realtime clock on each server is relatively in sync.';
					pb_backupbuddy::status( 'error', $message );
					die( json_encode( array( 'success' => false, 'error' => $message ) ) );
				}
				// Verify signature.
				$calculatedSignature = md5( $time . $verb . $key_public . $keyArr['key_secret'] . $filecrc );
				if ( $calculatedSignature != $signature ) { // Key matched but signature failed. Data has been tempered with or damaged in transit.
					return false;
				} else {
					return true;
				}
			}
		}
		return false;
	}
	
	public static function key_to_array( $key ) {
		$key = trim( $key );
		$key = base64_decode( $key );
		$key = json_decode( $key, true );
		return $key;
	}
	
	
	public static function validate_api_key( $key ) {
		if ( ! defined( 'BACKUPBUDDY_API_ENABLE' ) || ( TRUE != BACKUPBUDDY_API_ENABLE ) ) {
			return false;
		}
		if ( ! defined( 'BACKUPBUDDY_API_SALT' ) || ( 'CHANGEME' == BACKUPBUDDY_API_SALT ) || ( strlen( BACKUPBUDDY_API_SALT ) < 5 ) ) {
			return false;
		}
		if ( '' == pb_backupbuddy::$options['api_key'] ) {
			return false;
		}
		
		
		$key = self::key_to_array( $key );
		if ( $key == pb_backupbuddy::$options['api_key'] ) {
			return true;
		} else {
			return false;
		}
		
	} // End validate_api_key().
	
	
	public static function generate_key() {
		if ( ! defined( 'BACKUPBUDDY_API_ENABLE' ) || ( TRUE != BACKUPBUDDY_API_ENABLE ) ) {
			return false;
		}
		if ( ! defined( 'BACKUPBUDDY_API_SALT' ) || ( 'CHANGEME' == BACKUPBUDDY_API_SALT ) || ( strlen( BACKUPBUDDY_API_SALT ) < 5 ) ) {
			return false;
		}
		
		$siteurl = site_url();
		$homeurl = home_url();
		$rand = pb_backupbuddy::random_string( 12 );
		$rand2 = pb_backupbuddy::random_string( 12 );
		
		$key = array(
			'key_version' => 1,
			'key_public' => md5( $rand . pb_backupbuddy::$options['log_serial'] . $siteurl . $homeurl . time() ),
			'key_secret' => md5( $rand2 . pb_backupbuddy::$options['log_serial'] . $siteurl . $homeurl . time() ),
			'key_created' => time(),
			'siteurl' => $siteurl,
			'homeurl' => $homeurl,
		);
		
		
		return base64_encode( json_encode( $key ) );
		
	} // End generate_api_key().
	
	
	/* _error()
	 *
	 * Logs error messages for retrieval with getErrors().
	 *
	 * @param	string		$message	Error message to log.
	 * @return	null
	 */
	private static function _error( $message ) {
		error_log( $message );
		self::$_errors[] = $message;
		pb_backupbuddy::status( 'error', $message );
		return false;
	}
	
	
	
	/* getErrors()
	 *
	 * Get any errors which may have occurred.
	 *
	 * @return	array 		Returns an array of string error messages.
	 */
	public static function getErrors() {
		return self::$_errors;
	} // End getErrors();
	
	
	
} // End class.
