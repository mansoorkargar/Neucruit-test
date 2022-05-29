<template>
    <div class="d-flex align-items-center setup_logo_section">
        <div class="logo">
            <img :src="'/images/logos/main-logo.svg'" alt="neucruit">
        </div>
        <div>
            <div class="main-text">neucruit</div>
            <div class="small-text">DATA DASHBOARD</div>
        </div>
    </div>
    <div class="setup_navigation_section">
        <router-link to="/" class="d-flex align-items-center nav-link dashboard">
            <img :src="'/images/icons/dashboard.svg'" alt="dashboard">
            <p class="txt-black">Dashboard</p>
        </router-link>
        <div class="engage_section">
            <span class="d-flex align-items-center engage">
                <div class="engage-text">Engage</div>
                <div class="line"></div>
            </span>
        </div>
        <div class="dashboard_nav under_dashboard">
            <router-link to="/design" class="d-flex align-items-center nav-link dashboard">
                <div class="icons_frame">
                    <img :src="'/images/icons/designicon.svg'">
                </div>
                <p class="txt-black">Design</p>
            </router-link>
            <router-link to="/outreach" class="d-flex align-items-center nav-link dashboard">
                <div class="icons_frame">
                    <img :src="'/images/icons/outreach.svg'">
                </div>
                <p class="txt-black">Outreach</p>
            </router-link>
            <router-link to="/manage" class="d-flex align-items-center nav-link dashboard">
                <div class="icons_frame">
                    <img :src="'/images/icons/manage.svg'" class="manage_icon" alt="manage">
                </div>
                <p class="txt-black">Manage</p>
            </router-link>
            <router-link to="/communications" class="d-flex align-items-center nav-link dashboard">
                <div class="icons_frame">
                    <img :src="'/images/icons/envelope-solid.svg'">
                </div>
                <p class="txt-black">Communications</p>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SideBar'
}
</script>

<style lang="scss" scoped>
.active {
    background: #E9EAF7;

    p {
        color: #4142A2!important;
    }
}

.main-text {
    margin-left: 12px;
    font-weight: 600;
    font-size: 24.0729px;
    line-height: 121.4%;
    text-align: center;
    color: #6D79B8;
    letter-spacing: 0.5px;
}

.small-text {
    margin-left: 12px;
    font-weight: 400;
    font-size: 6.12766px;
    line-height: 121.4%;
    color: #6D79B8;
}

.left_container .setup_logo_section .logo img{
    width: 38px;
}

.nav-link {
    padding: 10px 0 0 0;

    .icons_frame {
        width: 10px;
    }
}

.engage-text {
    width: unset!important;
    height: unset!important;
    margin: 3px 0 0 -2px !important;
    font-weight: 700;
    font-size: 13px;
    line-height: 15px;
    letter-spacing: 0.01em;
    color: #6D79B8;
}

.line {
    width: 65%!important;
    height: 1px;
    background-color: #6D79B8;
}
.left_container .setup_navigation_section .engage_section{
    padding-left: 22px;
    overflow: auto;
    margin-bottom: 18px;
    margin-top: 9px;
}

.left_container .setup_navigation_section .dashboard{
    width: 100%;
    padding: 15px 26px 15px;
}
.left_container .setup_navigation_section .dashboard img{
    width: 13px;
}
.left_container .setup_navigation_section .dashboard p{
    margin-left: 11px;
    font-size: 17px;
    color:#343F44;
}
.left_container .setup_navigation_section .engage_section{
    padding: 0px 0px;
    padding-left: 22px;
    overflow: hidden;
}
.left_container  .dashboard_nav .dashboard{
    width: 100%;
    padding: 12px 27px 12px;
}
.left_container .dashboard_nav .dashboard .nav-link .icons_frame{
    width: 16px;
}
.left_container .dashboard_nav .dashboard  .setup_navigation_section .dashboard p{
    font-size: 17.178px;
}
.txt-black{
    margin-left: 13px;
    font-size: 17px;
}
.left_container .dashboard_nav .dashboard  .setup_navigation_section .dashboard img{
    width: 15px;
}
.under_dashboard .nav-link .icons_frame{
    margin-right: 5px;
}

.under_dashboard a, .setup_navigation_section a {
    text-decoration:none;
}
</style>
