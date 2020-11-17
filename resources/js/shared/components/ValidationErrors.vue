<template>
	<div>
		<div 
			class="invalid-feedback" 
			v-for="(error, index) in errors"
			:key="key(index)"
		>{{ error }}</div>
	</div>

</template>

<script>

export default {
	props: ["errors"],
	data() {
		return {

		};
	},
	computed: {

	},
	created() {

	},
	methods: {
		key(index) {
			console.log("ValidationErrors.vue key() index => ", index);

			//return 'validation_error_ ${index} _ ${Math.random()}';	//ES6			
			return 'validation_error_' + index + '_' + Math.random();	//ES5		
		},
	},
};
</script>

<style scoped>
.form-control.is-invalid ~ div > .invalid-feedback {
	display: block;
}
</style>