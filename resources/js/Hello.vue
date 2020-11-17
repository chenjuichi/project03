<template>
	<div>
        <div class="links">
            <!-- 建立 Vue Router 連結-->
            <router-link to="/hello1"></router-link>
            <router-link to="/hello2"></router-link>
        </div>
        <router-view></router-view> <!-- Vue Router 代入的內容 -->
	</div>
</template>
