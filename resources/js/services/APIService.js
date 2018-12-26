import axios from 'axios';

const CancelToken = axios.CancelToken

export default class APIService {
  static getEntries(title) {
    return new GetEntriesAPI(title);
  }
}

class GetEntriesAPI {
  constructor(title) {
    this.title = title
  }

  request() {
    return axios.get(`/api/entries?s=${this.title}`, {
      cancelToken: new CancelToken(c => this.cancel = c)
    })
  }
}