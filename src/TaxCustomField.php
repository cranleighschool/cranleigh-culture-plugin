<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 26/11/2018
 * Time: 21:33
 */

namespace FredBradley\CranleighCulturePlugin;


class TaxCustomField {

	public static function hasIssuuEmbed( $term ) {

		if ( self::getIssuuEmbed( $term ) !== null ) {
			return true;
		}

		return false;
	}

	public static function getIssuuEmbed( $term ) {


		$meta = get_option( "taxonomy_term_$term->term_id" );

		if (isset($meta['issuu_embed'])) {
			return "<center>".stripslashes(OEmbed::getOembed($meta['issuu_embed'])->html)."</center>";
		}
		return null;
	}

	public static function run() {

		// Add the fields to the "presenters" taxonomy, using our callback function
		add_action( 'culture-mag-edition_edit_form_fields', [ self::class, 'presenters_taxonomy_custom_fields' ], 1,
			2 );

		// Save the changes made on the "presenters" taxonomy, using our callback function
		add_action( 'edited_culture-mag-edition', [ self::class, 'save_taxonomy_custom_fields' ], 1, 2 );
	}

	// A callback function to add a custom field to our "presenters" taxonomy
	public static function presenters_taxonomy_custom_fields( $tag ) {

		// Check for existing taxonomy meta for the term you're editing
		$t_id      = $tag->term_id; // Get the ID of the term you're editing
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
		?>

		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="issuu_embed"><?php _e( 'ISSUU Document URL' ); ?></label>
			</th>
			<td>

				<input type="url" name="term_meta[issuu_embed]" id="term_meta[issuu_embed]" rows="5" style="width:100%;" value="<?php echo stripslashes($term_meta[ 'issuu_embed' ]) ? stripslashes($term_meta[ 'issuu_embed' ]) : ''; ?>" /><br />
				<span class="description"><?php _e( 'The url to the document on ISSUU' ); ?></span>
			</td>
		</tr>

		<?php
	}

	// A callback function to save our extra taxonomy field(s)
	public static function save_taxonomy_custom_fields( $term_id ) {

		if ( isset( $_POST[ 'term_meta' ] ) ) {
			$t_id      = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$cat_keys  = array_keys( $_POST[ 'term_meta' ] );
			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST[ 'term_meta' ][ $key ] ) ) {
					$term_meta[ $key ] = $_POST[ 'term_meta' ][ $key ];
				}
			}
			//save the option array
			update_option( "taxonomy_term_$t_id", $term_meta );
		}
	}
}
