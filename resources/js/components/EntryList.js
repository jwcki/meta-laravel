import React, {
  Component
} from 'react';
import Entry from './Entry';

export default class EntryList extends Component {
  render() {
    return (
      <div className='d-flex flex-wrap justify-content-around align-items-stretch'>
        {!this.props.entries || this.props.entries.length === 0 ? (
          <li className=''>
            No Records...
          </li>
        ) : (
            this.props.entries.map(entry => (
              <Entry
                key={entry.imdbID}
                className='flex-fill'
                entry={entry}
              />
            ))
          )}
      </div>
    );
  }
}
