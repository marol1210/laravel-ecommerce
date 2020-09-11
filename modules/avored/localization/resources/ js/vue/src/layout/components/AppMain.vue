<template>
  <section class="app-main">
    <transition name="fade-transform" mode="out-in">
      <!--<router-view :key="key" />-->
      <el-tabs v-model="editableTabsValue" type="card"  @tab-remove="removeTab">
        <el-tab-pane
          :key="item.name"
          v-for="(item, index) in editableTabs"
          :label="item.title"
          :name="item.name"
          :closable="index>1"
        >
          <iframe :src="item.page_url" style="width: 100%;height: 680px;" frameborder="0"></iframe>
        </el-tab-pane>
      </el-tabs>

    </transition>
  </section>
</template>

<script>
export default {
 data() {
    return {
      editableTabsValue: '2',
      editableTabs: [{
        title: '首页',
        name: '1',
        page_url: 'http://www.sina.com.cn'
      }, {
        title: '快捷键',
        name: '2',
        page_url: 'http://www.baidu.com'
      }],
      tabIndex: 2
    }
  },
   methods: {
      addTab(title,pageUrl) {
        let newTabName = ++this.tabIndex + '';
        this.editableTabs.push({
          title: title,
          name: newTabName,
          page_url: pageUrl
        });
        this.editableTabsValue = newTabName;
      },
      removeTab(targetName) {
        let tabs = this.editableTabs;
        let activeName = this.editableTabsValue;
        if (activeName === targetName) {
          tabs.forEach((tab, index) => {
            if (tab.name === targetName) {
              let nextTab = tabs[index + 1] || tabs[index - 1];
              if (nextTab) {
                activeName = nextTab.name;
              }
            }
          });
        }
        
        this.editableTabsValue = activeName;
        this.editableTabs = tabs.filter(tab => tab.name !== targetName);
      }
    },
  name: 'AppMain',
  computed: {
    key() {
      return this.$route.path
    }
  }
}
</script>

<style scoped>
.app-main {
  /*50 = navbar  */
  min-height: calc(100vh - 50px);
  width: 100%;
  position: relative;
  overflow: hidden;
}
.fixed-header+.app-main {
  padding-top: 50px;
}
</style>

<style lang="scss">
// fix css style bug in open el-dialog
.el-popup-parent--hidden {
  .fixed-header {
    padding-right: 15px;
  }
}
</style>
