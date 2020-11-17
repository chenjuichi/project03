export default {
	data() {
		return {
			errors: null,
		};
	},
	methods: {		
		errorFor(field) {
			//console.log("mixins.js errorFor this.errors => ", this.errors);
			//console.log("mixins.js errorFor field => ", field);
			return null !== this.errors && this.errors[field] ? this.errors[field] : null;			
		}
	}
};
