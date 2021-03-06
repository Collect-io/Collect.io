import debounce from 'lodash-es/debounce'
import throttle from 'lodash-es/throttle'
import {Component, Vue} from 'vue-property-decorator'
import WithRender from './App.html'

import ColllectHeader from './components/header/Header'

import authStore from './store/modules/auth'
import windowStore from './store/modules/window'

@WithRender
@Component({
  components: {
    ColllectHeader,
  },
})
export default class App extends Vue {
  private get isAuthenticated() {
    return authStore.isAuthenticated
  }

  private handleScroll() {
    windowStore.dispatchWindowScroll(window.scrollY)
  }

  private handleResize() {
    windowStore.dispatchWindowResize({
      width: window.innerWidth,
      height: window.innerHeight,
    })
  }

  private mounted() {
    authStore.dispatchGetCurrentUser()

    window.addEventListener('scroll', throttle(this.handleScroll, 300, {leading: false}))
    window.addEventListener('resize', debounce(this.handleResize, 300, {leading: true}))
  }
}
