import React, {
  Component
} from 'react';

export default class Entry extends Component {
  render() {
    const entry = this.props.entry
    return (
      <div
        className={this.props.className}
        style={{ maxWidth: '300px', width: '300px' }}
      >
        < div >
          {
            entry.poster &&
            <img
              src={entry.poster}
            />
          }
        </div >
        <div>
          <h5>{entry.title}</h5>
          <span>{entry.year} - {entry.type}</span>
        </div >
      </div >
    );
  }
}
