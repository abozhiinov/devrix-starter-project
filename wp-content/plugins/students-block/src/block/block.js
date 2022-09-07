/**
 * BLOCK: students-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

import { InspectorControls } from "@wordpress/block-editor";
import { Fragment } from "@wordpress/element";
import {
	PanelBody,
	PanelRow,
	TextControl,
	CheckboxControl
} from "@wordpress/components";
import { pickBy, _ } from 'lodash';
import { useSelect } from '@wordpress/data'
import { combineReducers } from 'redux';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

//let students = '';
/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'cgb/block-students-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Student Block' ), // Block title.
	icon: 'businessperson', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'students-block — CGB Block' ),
		__( 'CGB Example' ),
		__( 'create-guten-block' ),
	],
	attributes: {
		number_of_students : {
			type: 'string',
			selector: '.number-of-students',
			default: '0'
		},
		active : {
			type: 'checkbox',
			selector: '.active',
			default: false
		},
		student_id : {
			type: 'string',
			selector: '.student-id',
			default: '0'
		},
		posts_final : {
			type : 'array',
			default : [{title: '', thumbnail: ''}]
		}
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: ( props ) => { 
		const { attributes, setAttributes } = props;

		let latestPostsQuery = pickBy(
			{
				per_page: Number(attributes.number_of_students),
				_embed: true,
				metaKey: 'status',
			}
		);

		if(attributes.student_id !== '0') latestPostsQuery = pickBy(
			{
				include: Number(attributes.student_id),
				per_page: parseInt(attributes.number_of_students),
				_embed: true,
				metaKey: 'status',
			}
		);

		let posts = useSelect( (select) => {
			return select('core').getEntityRecords(
				'postType',
				'student',
				latestPostsQuery,
			);
		}, [])

		setAttributes({posts_final: posts})

		const nos_fill = ( attributes.number_of_students.length && !attributes.student_id.length)
		const id_fill  = ( attributes.student_id.length && !attributes.number_of_students.length)
			return (
				<Fragment>
					<InspectorControls>
						<PanelBody title= { __("Settings") } initialOpen={true} >
							<PanelRow>
								<TextControl 
									className='number-of-students'
									label= { __("Number of Students", 'students-block') }
									help= {__('When an ID is provided, this field is disabled')}
									placeholder= { __('Type a number...') }
									value= { attributes.number_of_students }
									onChange= { (value) => {
										setAttributes({ number_of_students: value }); 
									} } 
									min= {'0'}
									disabled= { id_fill }
								/> 
							</PanelRow>
							<PanelRow>
								<CheckboxControl
									className='active'
									label= { __("Show Active / Inactive", 'students-block') }
									onChange= { (value) => { 
										setAttributes({ active: value });
									} }
									type= {'checkbox'}
									checked= {attributes.active}
								/>
							</PanelRow>
							<PanelRow>
								<TextControl
									className='student-id'
									label= { __("Select Student by ID", 'students-block') }
									help= {__('When number of students is filled, this field is disabled')}
									placeholder= { __('Type an ID...') }
									onChange= { (value) => {
										setAttributes({ student_id: value });
									} }
									value= { attributes.student_id }
									min= {'0'}
									disabled= { nos_fill }
								/>
							</PanelRow>
						</PanelBody>
					</InspectorControls>
					<div className={ props.className }>
						{ posts && (
							<div>
								{
									posts.map( (post) => {
										if(post.meta.status === attributes.active){
											const thumbnail_src =
												post &&
												post._embedded &&
												post._embedded["wp:featuredmedia"][0]['source_url'];
											
											return  <div className='single-student'> 
														<div className='student-title'>{ post.title.rendered }</div> 
														<img src={ thumbnail_src } />
													</div> 
										}
										
									})
								}
							</div>
						) }
					</div>
				</Fragment>
			);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: ( props ) => {
		const { attributes } = props;
		return (
			<div className={props.className}> 
				{attributes.posts_final.map( (post) => {
					const thumbnail_src =
					post &&
					post._embedded &&
					post._embedded["wp:featuredmedia"][0]['source_url'];
					return  <div className='single-student'> 
						<div className='student-title'> <a href= { post.link }> { post.title.rendered } </a> </div> 
						<img src={ thumbnail_src } />
					</div>  
					}
				)}
			</div>
		);
	},
} );
